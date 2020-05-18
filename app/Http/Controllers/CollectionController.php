<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCollection;
use App\Models\Deck;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CollectionController extends Controller
{
    /**
     * Страница колекций
     */
    public function index(): View
    {
        $collections = Deck::where('access', 'public')->latest('rating')->get();

        return view('collections', compact('collections'));
    }

    /**
     * Добавление колоды к пользователю
     */
    public function add(AddCollection $request, Deck $collection): JsonResponse
    {
        Deck::processAddDeck($collection);

        return $this->respondSuccess();
    }
}
