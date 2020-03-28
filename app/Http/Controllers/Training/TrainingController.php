<?php

namespace App\Http\Controllers\Training;

use App\Deck;
use App\Flashcard;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LayoutResponse;
use App\Http\Resources\FlashcardResource;
use App\Http\Services\RandomPicker;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

abstract class TrainingController extends Controller
{
    use LayoutResponse;

    protected string $trainingComponentPath = '';

    protected string $flashcardHtml = '';

    protected Collection $flashcards;

    protected Flashcard $flashcard;

    protected Request $request;

    protected Deck $deck;

    /**
     * Получение следующего слова для тренировки
     *
     * @param  Deck  $deck
     * @param  Request  $request
     *
     * @return string
     * @throws Exception
     */
    public function getWord(Deck $deck, Request $request): string
    {
        $this->init($deck, $request);
        $this->setLayout();

        return $this->sendResponse();
    }

    /**
     * Возврат ответа на клиент.
     *
     * @return string
     */
    protected function sendResponse(): string
    {
        return json_encode([
            'flashcard' => new FlashcardResource($this->flashcard),
            'layout' => $this->flashcardHtml,
            'deck' => $this->deck,
        ]);
    }

    /**
     * Инициализация переменных
     *
     * @param  Deck  $deck
     * @param  Request  $request
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
     * @return mixed
     * @throws Exception
     */
    private function getIndex()
    {
        $weights = array_get($this->flashcards->toArray(), 'status_pivot.status.weight');

        $randomPicker = new RandomPicker();
        $randomPicker->addElements($weights);

        return $randomPicker->getRandomElement();
    }

    /**
     * Задание верстки, которая будет возвращена на клиент
     */
    protected function setLayout(): void
    {
        $this->flashcardHtml = $this->prepareLayout($this->trainingComponentPath, ['flashcard' => $this->flashcard]);
    }
}
