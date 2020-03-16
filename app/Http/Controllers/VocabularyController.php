<?php

namespace App\Http\Controllers;

use App\Flashcard;
use Illuminate\Database\Eloquent\Builder;

class VocabularyController extends Controller
{
    public function index()
    {
        $flashcards = Flashcard::with('deck')->whereHas('deck', function (Builder $query) {
            $query->where('user_id', user()->id);
        })->get();

        return view('vocabulary', ['flashcards' => $flashcards]);
    }
}
