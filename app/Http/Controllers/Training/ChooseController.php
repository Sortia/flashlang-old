<?php

namespace App\Http\Controllers\Training;

use App\Http\Resources\FlashcardResource;
use App\Models\Deck;
use Exception;
use Illuminate\Http\Request;

/**
 * Выбор одного правильного варианта перевода из 6 предложенных
 *
 * Class ChooseController
 * @package App\Http\Controllers\Training
 */
class ChooseController extends TrainingController implements Training
{
    /**
     * Получить следующее слово для тренировки
     *
     * @param Deck $deck
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function getWord(Deck $deck): array
    {
        $flashcard = $this->service->getTrainingFlashcard($deck->flashcards);
        $words     = $this->service->getRandomWords();

        $words->add($flashcard->getHiddenText())->shuffle();

        $layout = $this->prepareLayout('training.components.study-choose', compact('flashcard', 'words'));
        $flashcard = FlashcardResource::make($flashcard);

        return compact('deck', 'flashcard', 'layout');
    }
}
