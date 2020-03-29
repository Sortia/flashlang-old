<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteFlashcard;
use App\Http\Requests\StoreFlashcard;
use App\Models\Flashcard;
use App\Repositories\DeckRepository;
use App\Repositories\FlashcardRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FlashcardController extends Controller
{
    use LayoutResponse;

    private FlashcardRepository $repository;

    /**
     * FlashcardController constructor.
     */
    public function __construct(FlashcardRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Сохранение новой карточки
     */
    public function store(StoreFlashcard $request, DeckRepository $deckRepository): JsonResponse
    {
        $deck = $deckRepository->getModel();

        $flashcard = $this->repository->store($request);

        $layout = $this->prepareLayout('deck.components.flashcard', compact('flashcard', 'deck'));

        return $this->respond($layout);
    }

    /**
     * Удаление карточки
     *
     * @throws Exception
     */
    public function destroy(DeleteFlashcard $request, Flashcard $flashcard): JsonResponse
    {
        $this->repository->delete($flashcard);

        return $this->respondSuccess();
    }

    /**
     * Проставление/изменение статуса
     */
    public function updateStatus(Request $request, Flashcard $flashcard): JsonResponse
    {
        $this->repository->updateStatus($flashcard, $request->value);

        return $this->respondSuccess();
    }
}
