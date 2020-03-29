<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LayoutResponse;
use App\Http\Resources\FlashcardResource;
use App\Http\Services\RandomPicker;
use App\Models\Deck;
use App\Models\Flashcard;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

abstract class TrainingController extends Controller
{
    use LayoutResponse;

    protected string $trainingComponentPath = '';

    protected string $layout = '';

    protected Collection $flashcards;

    protected Flashcard $flashcard;

    protected Request $request;

    protected Deck $deck;

    /**
     * Получение следующего слова для тренировки
     *
     * @throws Exception
     */
    public function getWord(Deck $deck, Request $request): string
    {
        $this->init($deck, $request);
        $this->setLayout();

        return $this->sendResponse();
    }

    /**
     * Задание верстки, которая будет возвращена на клиент
     */
    protected function setLayout(): void
    {
        $this->layout = $this->prepareLayout($this->trainingComponentPath, ['flashcard' => $this->flashcard]);
    }

    /**
     * Возврат ответа на клиент.
     */
    protected function sendResponse(): string
    {
        return json_encode([
            'flashcard' => new FlashcardResource($this->flashcard),
            'layout' => $this->layout,
            'deck' => $this->deck,
        ]);
    }

    /**
     * Инициализация переменных
     *
     * @throws Exception
     */
    private function init(Deck $deck, Request $request): void
    {
        $this->deck = $deck;
        $this->request = $request;
        $lastId = Session::get('training.last_flashcard_id');

        $query = Flashcard::with('statusPivot.status');
        $query->where('deck_id', $deck->id);

        if ($deck->flashcards->count() > 1 && $lastId) {
            $query->whereNotIn('id', [$lastId]);
        }

        $this->flashcards = $query->get();
        $this->flashcard = $this->flashcards->slice($this->getIndex(), 1)->first();

        Session::put('training.last_flashcard_id', $this->flashcard->id);
    }

    /**
     * Получение индекса карточки, которая будет отображена
     *
     * @throws Exception
     */
    private function getIndex(): int
    {
        $weights = array_get($this->flashcards->toArray(), 'status_pivot.status.weight');

        $randomPicker = new RandomPicker();
        $randomPicker->addElements($weights);

        return $randomPicker->getRandomElement();
    }
}
