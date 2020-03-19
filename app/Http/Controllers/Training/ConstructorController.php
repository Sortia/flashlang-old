<?php

namespace App\Http\Controllers\Training;

class ConstructorController extends TrainingController
{
    protected string $trainingComponentPath = 'training.components.word-constructor';

    protected string $finishComponentPath = 'training.components.word-constructor-finish';

    public function setLayout(): void
    {
        $this->flashcardHtml = $this->prepareLayout($this->trainingComponentPath, ['flashcard' => $this->flashcard]);
    }
}
