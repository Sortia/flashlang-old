<?php

namespace App\Http\Controllers;

use App\Deck;
use App\Http\Requests\StoreDeck;
use Exception;
use App\Status;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class DeckController extends Controller
{
    /**
     * Список колод пользователя
     */
    public function index(): View
    {
        return view('deck.list', [
            'decks' => Deck::userDecks()
        ]);
    }

    /**
     * Форма создания
     */
    public function create(): View
    {
        return view('deck.form', [
            'deck' => Deck::class,
            'statuses' => Status::all(),
        ]);
    }

    /**
     * Форма редатирования
     */
    public function edit(Deck $deck): View
    {
        return view('deck.form', [
            'deck' => $deck,
            'statuses' => Status::all(),
        ]);
    }

    /**
     * Создание/редактирование
     */
    public function store(StoreDeck $request): RedirectResponse
    {
        $deckData = array_merge($request->all(), ['user_id' => user()->id]);

        /** @var Deck $deck */
        $deck = Deck::on()->updateOrCreate(['id' => $request->id, 'user_id' => user()->id], $deckData);
        $deck->users()->create(['user_id' => user()->id]);

        $this->add($deck);

        return redirect(route('deck.index'));
    }

    /**
     * Если удаляет владелец - удаляется у всех пользователей,
     * если любой другой пользователь - только у него
     *
     * @throws Exception
     */
    public function destroy(Deck $deck): RedirectResponse
    {
        ($deck->isOwner() && $deck->isPrivate()) ? $deck->delete() : $deck->user->delete();

        return redirect(route('deck.index'));
    }

    /**
     * Проставление/изменение рейтинга
     */
    public function updateStatus(Deck $deck, Request $request): void
    {
        $deck->rate()->updateOrCreate(['user_id' => user()->id],['value' => $request->value]);
        $deck->update(['rating' => $deck->rates->pluck('value')->avg()]);
    }
}
