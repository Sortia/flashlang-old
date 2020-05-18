<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use App\Models\Deck;
use App\Models\DeckUser;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * "Доска" тренировок
     */
    public function dashboard(): View
    {
        $decks = Deck::whereIn('id', DeckUser::userDecks())->get();

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
