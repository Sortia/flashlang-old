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
     *
     *  По факту создается новая колода и в нее дублируются карточки
     */
    public function add(AddCollection $request, Deck $collection): JsonResponse
    {
        $deck = Deck::create([
            'name' => $collection->name,
            'description' => $collection->description,
            'user_id' => user()->id,
        ]);

        $collection->flashcards->each(function($item) use ($deck) {
            $deck->flashcards()->create($item->toArray());
        });

        return $this->respondSuccess();
    }
}
