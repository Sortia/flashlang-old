<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use App\Models\Deck;
use App\Repositories\DeckRepository;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * "Доска" тренировок
     */
    public function dashboard(DeckRepository $deckRepository): View
    {
        $decks = $deckRepository->get();

        return view('training.dashboard', compact('decks'));
    }

    /**
     * Страница тренировки
     */
    public function study(Deck $deck, string $typeTraining): View
    {
        return view('training.' . $typeTraining, compact('deck'));
    }
}
