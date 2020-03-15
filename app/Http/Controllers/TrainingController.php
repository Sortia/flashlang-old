<?php

namespace App\Http\Controllers;

use App\Deck;

class TrainingController extends Controller
{
    public function dashboard()
    {
        return view('training.dashboard', ['decks' => Deck::all()]);
    }

    public function study(Deck $deck)
    {
        return view('training.study', ['deck' => $deck]);
    }
}
