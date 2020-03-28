<?php

namespace App\Http\Controllers\Training;

use App\Flashcard;
use Illuminate\Support\Collection;

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
        $words = $this->getRandomWords();
        $words->add($this->flashcard->getHiddenText())->shuffle();

        $this->layout = $this->prepareLayout($this->trainingComponentPath, [
            'flashcard' => $this->flashcard,
            'words' => $words
        ]);
    }

    /**
     * Поулчение пяти дополнительных слов
     */
    private function getRandomWords(): Collection
    {
        return Flashcard::on()
            ->where('id', '<>', $this->flashcard->id)
            ->inRandomOrder()
            ->take(5)
            ->pluck(get_hidden_side_name());
    }
}
