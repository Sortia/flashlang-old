<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use Illuminate\View\View;

class VocabularyController extends Controller
{
    /**
     * Страница словаря
     */
    public function index(): View
    {
        $flashcards = Flashcard::my()->latest('id')->get();

        return view('vocabulary', compact('flashcards'));
    }
}
