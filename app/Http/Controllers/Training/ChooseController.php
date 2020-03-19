<?php

namespace App\Http\Controllers\Training;

use App\Flashcard;
use Illuminate\Support\Collection;

class ChooseController extends TrainingController
{
    protected string $trainingComponentPath = 'training.components.study-choose';

    protected string $finishComponentPath = 'training.components.word-constructor-finish';

    protected function setLayout(): void
    {
        $words = $this->getRandomWords();
        $words->add($this->flashcard->back_text)->shuffle();

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
            ->pluck('back_text');
    }
}
