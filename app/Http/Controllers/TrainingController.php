<?php

namespace App\Http\Controllers;

use App\Deck;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function dashboard()
    {
        return view('training.dashboard', ['decks' => Deck::all()]);
    }

    public function study(Deck $deck, string $typeTraining)
    {
        return view('training.' . $typeTraining, ['deck' => $deck]);
    }

    public function getWord(Deck $deck, Request $request)
    {
        if ($request->offset >= $deck->flashcards->count()) {
            return response()->json(['layout' => ajax_view('training.components.word-constructor-finish')]);
        }

        $flashcard = $deck->flashcards->slice($request->offset, 1)->first();
        $flashcardHtml = ajax_view('training.components.word-constructor', ['flashcard' => $flashcard]);

        return response()->json([
            'flashcard' => $flashcard,
            'layout' => $flashcardHtml,
        ]);
    }
}
