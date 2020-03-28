<?php

namespace App\Http\Controllers;

use App\Flashcard;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class VocabularyController extends Controller
{
    /**
     * Страница словаря
     *
     * @return Factory|View
     */
    public function index()
    {
        $flashcards = Flashcard::getAll();

        return view('vocabulary', ['flashcards' => $flashcards]);
    }
}
