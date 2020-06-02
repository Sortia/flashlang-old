<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LayoutResponse;
use App\Http\Services\TrainingService;
use App\Models\Deck;
use Illuminate\View\View;

/**
 * Абстрактый класс тренировок
 *
 * Class TrainingController
 * @package App\Http\Controllers\Training
 */
class TrainingController extends Controller
{
    use LayoutResponse;

    protected TrainingService $service;

    public function __construct(TrainingService $service)
    {
        $this->service = $service;
    }

    /**
     * "Доска" тренировок
     */
    public function dashboard(): View
    {
        $decks = Deck::my()->get();

        return view('training.dashboard', compact('decks'));
    }

    /**
     * Страница тренировки
     */
    public function study(string $typeTraining, Deck $deck): View
    {
        $flashcards = $deck->flashcards->shuffle();

        return view('training.' . $typeTraining, compact('flashcards'));
    }

}
