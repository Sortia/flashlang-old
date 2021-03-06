<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeck;
use App\Models\Deck;
use App\Models\Status;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class DeckController extends Controller
{
    /**
     * Список колод пользователя
     */
    public function index(Request $request): View
    {
        $decks = Deck::my()->get();

        return view('deck.list', compact('decks'));
    }

    /**
     * Форма создания
     */
    public function create(): View
    {
        $deck     = new Deck();
        $statuses = Status::all();

        return view('deck.form', compact('deck', 'statuses'));
    }

    /**
     * Форма редатирования
     */
    public function edit(Deck $deck): View
    {
        $statuses = Status::all();

        return view('deck.form', compact('deck', 'statuses'));
    }

    /**
     * Создание/редактирование
     */
    public function store(StoreDeck $request): RedirectResponse
    {
        Deck::updateOrCreate(['id' => $request->id, 'user_id' => user()->id], $request->all());

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
        $deck->delete();

        return redirect(route('deck.index'));
    }

    /**
     * Проставление/изменение рейтинга
     */
    public function updateStatus(Deck $deck, Request $request): JsonResponse
    {
        $deck->rate()->updateOrCreate(['user_id' => user()->id, 'value' => $request->value]);

        $deck->update(['rating' => $deck->rates->pluck('value')->avg()]);

        return $this->respondSuccess();
    }
}
