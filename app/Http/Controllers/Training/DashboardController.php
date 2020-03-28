<?php

namespace App\Http\Controllers\Training;

use App\Deck;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * "Доска" тренировок
     */
    public function dashboard(): View
    {
        return view('training.dashboard', ['decks' => Deck::userDecks()]);
    }

    /**
     * Страница тренировки
     */
    public function study(Deck $deck, string $typeTraining): View
    {
        return view('training.' . $typeTraining, compact('deck'));
    }
}
