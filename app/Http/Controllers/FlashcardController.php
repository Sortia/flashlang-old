<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteFlashcard;
use App\Http\Requests\StoreFlashcard;
use App\Models\Deck;
use App\Models\Flashcard;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FlashcardController extends Controller
{
    use LayoutResponse;

    /**
     * Сохранение новой карточки
     */
    public function store(StoreFlashcard $request): JsonResponse
    {
        $deck      = Deck::findOrFail($request->deck_id);
        $flashcard = $deck->flashcards()->updateOrCreate(['id' => $request->id], $request->all())->refresh();
        $layout    = $this->prepareLayout('deck.components.flashcard', compact('flashcard', 'deck'));

        return $this->respond($layout);
    }

    /**
     * Удаление карточки
     *
     * @throws Exception
     */
    public function destroy(DeleteFlashcard $request, Flashcard $flashcard): JsonResponse
    {
        $flashcard->delete();

        return $this->respondSuccess();
    }

    /**
     * Проставление/изменение статуса
     */
    public function updateStatus(Request $request, Flashcard $flashcard): JsonResponse
    {
        $flashcard->update(['status_id' => $request->status_id]);

        return $this->respondSuccess();
    }
}
