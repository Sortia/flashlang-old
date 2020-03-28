<?php

namespace App\Http\Controllers\Training;

use App\Deck;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('training.dashboard', ['decks' => Deck::userDecks()]);
    }

    public function study(Deck $deck, string $typeTraining)
    {
        return view('training.' . $typeTraining, ['deck' => $deck]);
    }
}
