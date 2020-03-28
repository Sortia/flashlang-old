<?php

namespace App\Http\Controllers;

use App\Deck;
use App\Flashcard;
use App\FlashcardUsers;
use App\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FlashcardController extends Controller
{
    /**
     * Сохранение новой карточки
     */
    public function store(Request $request): JsonResponse
    {
        $flashcard =  Flashcard::on()->updateOrCreate(['id' => $request->get('id')], $request->all());

        FlashcardUsers::on()->firstOrCreate([
            'flashcard_id' => $flashcard->id,
            'user_id' => user()->id,
        ]);

        $flashcardHtml = view('deck.components.flashcard', ['flashcard' => $flashcard, 'deck' => Deck::class])->toHtml();

        return response()->json($flashcardHtml);
    }

    /**
     * Удаление карточки
     *
     * @throws Exception
     */
    public function destroy(Flashcard $flashcard): void
    {
        $flashcard->delete();
    }

    /**
     * Проставление/изменение статуса
     */
    public function updateStatus(Flashcard $flashcard, Request $request): JsonResponse
    {
        $statusId = Status::where('value', $request->value)->value('id');

        return $flashcard->statusPivot->update(['status_id' => $statusId]);
    }
}
