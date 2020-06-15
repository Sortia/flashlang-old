<?php

namespace App\Http\Controllers\Training;

use App\Http\Resources\FlashcardResource;
use App\Models\Deck;
use Exception;
use Illuminate\Http\Request;

/**
 * Составление перевода слова из предложенных букв
 *
 * Class ConstructorController
 * @package App\Http\Controllers\Training
 */
class ConstructorController extends TrainingController implements Training
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
        $layout    = $this->prepareLayout('training.components.word-constructor', compact('flashcard'));
        $flashcard = FlashcardResource::make($flashcard);

        return compact('deck', 'flashcard', 'layout');
    }
}
