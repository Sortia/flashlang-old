<?php

namespace App\Http\Controllers\Training;

/**
 * Выбор одного правильного варианта перевода из 6 предложенных
 *
 * Class ChooseController
 * @package App\Http\Controllers\Training
 */
class ChooseController extends TrainingController
{
    protected string $trainingComponentPath = 'training.components.study-choose';

    /**
     * Задание верстки, которая будет возвращена на клиент
     */
    protected function setLayout(): void
    {
        $words = $this->repository->getRandomWords();
        $words->add($this->flashcard->getHiddenText())->shuffle();

        $this->layout = $this->prepareLayout($this->trainingComponentPath, [
            'flashcard' => $this->flashcard,
            'words' => $words
        ]);
    }

}
