<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LayoutResponse;
use App\Http\Resources\FlashcardResource;
use App\Models\Deck;
use App\Models\Flashcard;
use App\Repositories\TrainingRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Абстрактый класс тренировок
 *
 * Class TrainingController
 * @package App\Http\Controllers\Training
 */
abstract class TrainingController extends Controller
{
    use LayoutResponse;

    protected string $trainingComponentPath = '';

    protected string $layout = '';

    protected TrainingRepository $repository;

    protected Collection $flashcards;

    protected Flashcard $flashcard;

    protected Request $request;

    protected Deck $deck;

    /**
     * TrainingController constructor.
     */
    public function __construct(TrainingRepository $repository)
    {
        $this->repository = $repository;
    }

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
            'layout'    => $this->layout,
            'deck'      => $this->deck,
        ]);
    }

    /**
     * Инициализация переменных
     *
     * @throws Exception
     */
    private function init(Deck $deck, Request $request): void
    {
        $this->request    = $request;
        $this->deck       = $deck;
        $this->flashcards = $this->repository->getFlashcards($deck);
        $this->flashcard  = $this->repository->getTrainingFlashcard($this->flashcards);
    }

}
