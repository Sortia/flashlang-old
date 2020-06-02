<?php

namespace App\Http\Controllers\Training;

use App\Models\Deck;

interface Training
{
    /**
     * Получить следующее слово для тренировки
     *
     * @param Deck $deck
     * @return array
     */
    function getWord(Deck $deck): array;
}
