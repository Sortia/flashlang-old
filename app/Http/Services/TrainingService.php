<?php

namespace App\Http\Services;

use App\Models\Deck;
use App\Models\Flashcard;
use Exception;
use Illuminate\Support\Collection;

class TrainingService
{
    private RandomPicker $randomPicker;

    /**
     * TrainingService constructor.
     * @param RandomPicker $randomPicker
     */
    public function __construct(RandomPicker $randomPicker)
    {
        $this->randomPicker = $randomPicker;
    }

    /**
     * Получение карточки, которая булет отображена пользователю
     *
     * @throws Exception
     */
    public function getTrainingFlashcard(Collection $flashcards)
    {
        $flashcard = $flashcards->slice($this->getIndex($flashcards), 1)->first();

        session(['training.last_flashcard_id' => $flashcard->id]);

        return $flashcard;
    }

    /**
     * Получение индекса карточки, которая будет отображена
     *
     * @throws Exception
     */
    private function getIndex(Collection $flashcards): int
    {
        $weights = $flashcards->pluck('statusPivot.status.weight');

        $this->randomPicker->addElements($weights);

        return $this->randomPicker->getRandomElement();
    }

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
