<?php

namespace App\Http\Controllers\Training;

use App\Flashcard;
use Illuminate\Support\Collection;

class ChooseController extends TrainingController
{
    protected string $trainingComponentPath = 'training.components.study-choose';

    protected function setLayout(): void
    {
        $words = $this->getRandomWords();
        $words->add($this->flashcard->getHiddenText())->shuffle();

        $this->flashcardHtml = $this->prepareLayout($this->trainingComponentPath, [
            'flashcard' => $this->flashcard,
            'words' => $words
        ]);
    }

    private function getRandomWords(): Collection
    {
        return Flashcard::on()
            ->where('id', '<>', $this->flashcard->id)
            ->inRandomOrder()
            ->take(5)
            ->pluck(getHiddenSideName());
    }
}
