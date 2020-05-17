<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCollection;
use App\Models\Deck;
use App\Repositories\CollectionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CollectionController extends Controller
{
    private CollectionRepository $repository;

    /**
     * CollectionController constructor.
     */
    public function __construct(CollectionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Страница колекций
     */
    public function index(): View
    {
        $collections = $this->repository->get();

        return view('collections', compact('collections'));
    }

    /**
     * Добавление колоды к пользователю
     */
    public function add(AddCollection $request, Deck $collection): JsonResponse
    {
        $this->repository->processAddDeck($collection);

        return $this->respondSuccess();
    }
}
