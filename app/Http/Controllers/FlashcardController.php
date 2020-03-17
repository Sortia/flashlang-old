<?php

namespace App\Http\Controllers;

use App\Flashcard;
use App\Status;
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
        $flashcardHtml = view('deck.components.flashcard', ['flashcard' => $flashcard])->toHtml();

        return response()->json($flashcardHtml);
    }

    public function destroy(Flashcard $flashcard)
    {
        return $flashcard->delete();
    }

    public function updateStatus(Flashcard $flashcard, Request $request)
    {
        $flashcard->update([
            'status_id' => Status::on()->where('value', $request->value)->value('id')
        ]);

        return response()->json($flashcard);
    }
}
