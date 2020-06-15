<?php

namespace App\Http\Controllers\Training;

use App\Models\Deck;
use Exception;
use Illuminate\Http\Request;

/**
 * Class FlashcardController
 * @package App\Http\Controllers\Training
 */
class FlashcardController extends TrainingController implements Training
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
        $layout    = $this->prepareLayout('training.components.slide-item', compact('flashcard'));

        return compact('deck', 'flashcard', 'layout');
    }

}
