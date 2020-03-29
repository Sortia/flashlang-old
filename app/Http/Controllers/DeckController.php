<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeck;
use App\Models\Deck;
use App\Repositories\DeckRepository;
use App\Repositories\StatusRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class DeckController extends Controller
{
    private DeckRepository $repository;

    /**
     * DeckController constructor.
     */
    public function __construct(DeckRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Список колод пользователя
     */
    public function index(): View
    {
        $decks = $this->repository->get();

        return view('deck.list', compact('decks'));
    }

    /**
     * Форма создания
     */
    public function create(StatusRepository $statusRepository): View
    {
        $deck = $this->repository->getModel();

        $statuses = $statusRepository->all();

        return view('deck.form', compact('deck', 'statuses'));
    }

    /**
     * Форма редатирования
     */
    public function edit(Deck $deck, StatusRepository $statusRepository): View
    {
        $statuses = $statusRepository->all();

        return view('deck.form', compact('deck', 'statuses'));
    }

    /**
     * Создание/редактирование
     */
    public function store(StoreDeck $request): RedirectResponse
    {
        $deck = $this->repository->store($request);

        $this->repository->processAddDeck($deck);

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
        $this->repository->delete($deck);

        return redirect(route('deck.index'));
    }

    /**
     * Проставление/изменение рейтинга
     */
    public function updateStatus(Deck $deck, Request $request): JsonResponse
    {
        $this->repository->updateStatus($deck, $request->value);

        return $this->respondSuccess();
    }
}
