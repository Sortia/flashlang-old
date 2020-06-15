<?php

namespace App\Http\Services;

use App\Models\Flashcard;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

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
    public function getTrainingFlashcard(Collection $flashcards): Flashcard
    {
        $flashcards = $this->exceptLastFlashcard($flashcards);
        $flashcard  = $flashcards->slice($this->getIndex($flashcards), 1)->first();

        $this->setLastFlashcard($flashcard->id);

        return $flashcard;
    }

    private function setLastFlashcard(int $flashcardId)
    {
        Redis::set("user:" . user()->id . ":last_word", $flashcardId);
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
    public function exceptLastFlashcard(Collection $flashcards): Collection
    {
        $lastId = Redis::get("user:" . user()->id . ":last_word");

        // Если в колоде только одна карточка - не убираем
        // Тоже самое если убирать нечего (т. е. это первое слово в тренировке)
        return ($flashcards->count() > 1 && $lastId)
            ? $flashcards->filter(fn($item) => $item->id !== $lastId)
            : $flashcards;
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
