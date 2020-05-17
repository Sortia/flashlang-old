<?php

namespace App\Http\Services;

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
        $weights = array_get($flashcards->toArray(), 'status_pivot.status.weight');

        $this->randomPicker->addElements($weights);

        return $this->randomPicker->getRandomElement();
    }
}
