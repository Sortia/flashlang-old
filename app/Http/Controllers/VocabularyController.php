<?php

namespace App\Http\Controllers;

use App\Flashcard;
use Illuminate\View\View;

class VocabularyController extends Controller
{
    /**
     * Страница словаря
     */
    public function index(): View
    {
        return view('vocabulary', ['flashcards' => Flashcard::getAll()]);
    }
}
