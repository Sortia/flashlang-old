<?php

namespace App\Http\Controllers;

use App\Models\DeckUser;
use App\Models\Flashcard;
use Illuminate\View\View;

class VocabularyController extends Controller
{
    /**
     * Страница словаря
     */
    public function index(): View
    {
        $flashcards = Flashcard::whereIn('deck_id', DeckUser::userDecks())->get();

        return view('vocabulary', compact('flashcards'));
    }
}
