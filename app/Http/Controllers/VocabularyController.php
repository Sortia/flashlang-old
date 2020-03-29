<?php

namespace App\Http\Controllers;

use App\Models\Flashcard;
use App\Repositories\FlashcardRepository;
use Illuminate\View\View;

class VocabularyController extends Controller
{
    /**
     * Страница словаря
     */
    public function index(FlashcardRepository $flashcardRepository): View
    {
        $flashcards = $flashcardRepository->get();

        return view('vocabulary', compact('flashcards'));
    }
}
