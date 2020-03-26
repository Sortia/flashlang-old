<?php

namespace App\Http\Controllers;

use App\Deck;
use App\DeckUser;
use App\FlashcardUsers;
use App\Status;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class DeckController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('deck.list', ['decks' => Deck::userDecks()]);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        return view('deck.form', [
            'deck' => Deck::class,
            'statuses' => Status::all(),
        ]);
    }

    /**
     * @param Deck $deck
     * @return Factory|View
     */
    public function edit(Deck $deck)
    {
        return view('deck.form', [
            'deck' => $deck,
            'statuses' => Status::all(),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $deckData = array_merge($request->all(), ['user_id' => user()->id]);

        /** @var Deck $deck */
        $deck = Deck::on()->updateOrCreate(['id' => $request->id], $deckData);

        $this->add($deck);

        return redirect(route('deck.index'));
    }

    /**
     * @param Deck $deck
     * @return RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Deck $deck)
    {
        if ($deck->isOwner()) {
            $deck->delete();
        } else {
            $deck->user->delete();
        }

        return redirect(route('deck.index'));
    }

    /**
     * Добавление колоды к пользователю
     *
     * @param Deck $deck
     * @return void
     */
    public function add(Deck $deck)
    {
        if ($deck->isPublic()) {
            DeckUser::on()->firstOrCreate(['user_id' => user()->id, 'deck_id' => $deck->id]);

            $deck->flashcards->each(function ($flashcard) {
                FlashcardUsers::on()->create([
                    'user_id' => user()->id,
                    'flashcard_id' => $flashcard->id
                ]);
            });
        }
    }
}
