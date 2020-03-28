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
     *
     * Ajax response
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
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
     * @param Flashcard $flashcard
     * @return void
     * @throws Exception
     */
    public function destroy(Flashcard $flashcard)
    {
        $flashcard->delete();
    }

    /**
     * Проставление/изменение статуса
     *
     * @param Flashcard $flashcard
     * @param Request $request
     * @return JsonResponse
     */
    public function updateStatus(Flashcard $flashcard, Request $request)
    {
        $flashcard->statusPivot->update([
            'status_id' => Status::on()->where('value', $request->value)->value('id')
        ]);

        return response()->json($flashcard);
    }
}
