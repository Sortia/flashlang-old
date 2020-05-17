<?php

namespace App\Repositories;

use App\Models\Deck;
use App\Models\Flashcard;
use Illuminate\Support\Collection;

class TrainingRepository
{
    /**
     * Получение карточек из колоды для тренировки (исключена карточка, которая была получена в прошлый раз)
     */
    public function getFlashcards(Deck $deck)
    {
        $lastId = session('training.last_flashcard_id');

        $query = Flashcard::where('deck_id', $deck->id);

        if ($deck->flashcards->count() > 1) {
            $query->whereKeyNot($lastId);
        }

        return $query->get();
    }

    /**
     * Поулчение пяти дополнительных слов
     */
    public function getRandomWords(): Collection
    {
        return Flashcard::whereKeyNot(session('training.last_flashcard_id'))
            ->inRandomOrder()
            ->take(5)
            ->pluck(get_hidden_side_name());
    }
}
