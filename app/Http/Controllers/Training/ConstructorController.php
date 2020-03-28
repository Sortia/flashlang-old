<?php

namespace App\Http\Controllers\Training;

class ConstructorController extends TrainingController
{
    protected string $trainingComponentPath = 'training.components.word-constructor';

    /**
     * Задание верстки, которая будет возвращена на клиент
     */
    public function setLayout(): void
    {
        $this->flashcardHtml = $this->prepareLayout($this->trainingComponentPath, ['flashcard' => $this->flashcard]);
    }
}
