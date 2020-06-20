<?php

namespace App\Http\Controllers\Training;

use App\Models\Deck;
use App\Models\Storybook;
use Exception;
use Illuminate\Http\Request;

class ReadingController extends TrainingController implements Training
{
    /**
     * Получить следующее предложение для тренировки
     *
     * @param Deck $deck
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function getWord(Deck $deck): array
    {
        $words = $deck->flashcards->implode('front_text', ' ');

        $storybook = Storybook::searchByQuery(['match' => ['text' => $words]], null, null, 20)->random();

        $layout = $this->prepareLayout('training.components.study-reading', compact('storybook'));

        return compact('layout');
    }
}
