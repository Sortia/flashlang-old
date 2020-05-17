<?php

namespace App\Repositories;

use App\Models\Collection;
use App\Models\Deck;
use App\Models\Flashcard;

trait AddDeck
{
    /**
     * Добавление колоды к пользователю
     * @param Deck|Collection $deck
     */
    public function processAddDeck($deck): void
    {
        $deck->users()->firstOrCreate(['user_id' => user()->id, 'deck_id' => $deck->id]);

        $deck->flashcards->each(function (Flashcard $flashcard) {
            $flashcard->users()->create([
                'user_id' => user()->id,
                'flashcard_id' => $flashcard->id
            ]);
        });
    }
}
