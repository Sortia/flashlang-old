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
    public function getTrainingFlashcard(Deck $deck): Flashcard
    {
        $flashcards = $this->exceptLastFlashcard($deck);
        $flashcard  = $flashcards->slice($this->getIndex($flashcards), 1)->first();

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
        $weights = $flashcards->pluck('status.weight');

        $this->randomPicker->addElements($weights);

        return $this->randomPicker->getRandomElement();
    }

    /**
     * Получение карточек из колоды для тренировки (исключена карточка, которая была получена в прошлый раз)
     */
    public function exceptLastFlashcard(Deck $deck): Collection
    {
        $lastId = session('training.last_flashcard_id');

        // Если в колоде только одна карточка - не убираем
        // Тоже самое если убирать нечего (т. е. это первое слово в тренировке)
        return ($deck->flashcards->count() > 1 && $lastId)
            ? $deck->flashcards->filter(fn($item) => $item->id !== $lastId)
            : $deck->flashcards;
    }

    /**
     * Поулчение пяти дополнительных слов (для тренировки ChooseWord)
     */
    public function getRandomWords(): Collection
    {
        return Flashcard::my()
            ->whereKeyNot(session('training.last_flashcard_id'))
            ->inRandomOrder()
            ->take(5)
            ->pluck(get_hidden_side_name());
    }
}
