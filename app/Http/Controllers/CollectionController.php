<?php

namespace App\Http\Controllers;

use App\Collection;
use App\Deck;
use App\Flashcard;
use App\Http\Requests\AddCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CollectionController extends Controller
{
    /**
     * Страница колекций
     */
    public function index(): View
    {
        return view('collections', ['collections' => Collection::getAll()]);
    }

    /**
     * Добавление колоды к пользователю
     */
    public function add(AddCollection $request, Deck $deck): JsonResponse
    {
        $deck->users()->firstOrCreate(['user_id' => user()->id, 'deck_id' => $deck->id]);

        $deck->flashcards->each(function (Flashcard $flashcard) {
            $flashcard->users()->create([
                'user_id' => user()->id,
                'flashcard_id' => $flashcard->id
            ]);
        });

        return $this->respondSuccess();
    }
}
