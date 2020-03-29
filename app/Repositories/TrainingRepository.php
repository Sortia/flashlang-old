<?php

namespace App\Repositories;

use App\Http\Services\RandomPicker;
use App\Models\Deck;
use App\Models\Flashcard;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class TrainingRepository
{
    protected RandomPicker $randomPicker;

    /**
     * TrainingRepository constructor.
     */
    public function __construct(RandomPicker $random_picker)
    {
        $this->randomPicker = $random_picker;
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

    /**
     * Поулчение пяти дополнительных слов
     */
    public function getRandomWords(): Collection
    {
        return Flashcard::on()
            ->whereKeyNot(session('training.last_flashcard_id'))
            ->inRandomOrder()
            ->take(5)
            ->pluck(get_hidden_side_name());
    }
}
