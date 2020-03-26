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
     * @param Flashcard $flashcard
     * @return bool|null
     * @throws Exception
     */
    public function destroy(Flashcard $flashcard)
    {
        return $flashcard->delete();
    }

    /**
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
