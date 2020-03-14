<?php

namespace App\Http\Controllers;

use App\Deck;
use App\Status;
use Illuminate\Http\Request;

class DeckController extends Controller
{
    public function index()
    {
        return view('deck.list', ['decks' => Deck::with('status')->get()]);
    }

    public function create()
    {
        return view('deck.form', [
            'statuses' => Status::all(),
        ]);
    }

    public function edit(Deck $deck)
    {
        return view('deck.form', [
            'deck' => $deck,
            'statuses' => Status::all(),
        ]);
    }

    public function store(Request $request)
    {
        Deck::on()->updateOrCreate(['id' => $request->get('id')], $request->all());

        return redirect(route('deck.index'));
    }

    public function destroy(Deck $deck)
    {
        $deck->delete();

        return redirect(route('deck.index'));
    }
}
