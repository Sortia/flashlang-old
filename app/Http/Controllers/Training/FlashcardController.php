<?php

namespace App\Http\Controllers\Training;

class FlashcardController extends TrainingController
{
    protected string $trainingComponentPath = 'training.components.slide-item';

    public function setLayout(): void
    {
        $this->flashcardHtml = $this->prepareLayout($this->trainingComponentPath, ['flashcard' => $this->flashcard]);
    }
}
