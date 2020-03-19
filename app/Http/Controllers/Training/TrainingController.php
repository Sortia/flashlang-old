<?php

namespace App\Http\Controllers\Training;

use App\Deck;
use App\Flashcard;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LayoutResponse;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    use LayoutResponse;

    protected string $trainingComponentPath = '';

    protected string $finishComponentPath = '';

    protected Flashcard $flashcard;

    protected Request $request;

    protected Deck $deck;

    protected string $flashcardHtml;

    public function dashboard()
    {
        return view('training.dashboard', ['decks' => Deck::all()]);
    }

    public function study(Deck $deck, string $typeTraining)
    {
        return view('training.' . $typeTraining, ['deck' => $deck]);
    }

    public function getFinish(Deck $deck, Request $request)
    {
        return response()->json(['layout' => $this->prepareLayout($this->finishComponentPath)]);
    }

    public function getWord(Deck $deck, Request $request): string
    {
        $this->init($deck, $request);
        $this->setLayout();

        return $this->sendResponse();
    }

    private function init(Deck $deck, Request $request): void
    {
        $this->deck = $deck;
        $this->request = $request;
        $this->flashcard = $deck->flashcards->sortBy('id')->slice($request->offset, 1)->first();
    }

    protected function sendResponse(): string
    {
        return json_encode([
            'flashcard' => $this->flashcard,
            'layout' => $this->flashcardHtml,
            'deck' => $this->deck,
        ]);
    }

    protected function setLayout(): void
    {
        // abstract method
    }
}
