<?php

namespace App\Http\Controllers\Training;

use App\Deck;
use App\Flashcard;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LayoutResponse;
use App\Http\Resources\FlashcardResource;
use App\Http\Service\RandomPicker;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class TrainingController extends Controller
{
    use LayoutResponse;

    protected string $trainingComponentPath = '';

    protected Collection $flashcards;

    protected Flashcard $flashcard;

    protected Request $request;

    protected Deck $deck;

    protected string $flashcardHtml;

    protected ?int $lastId;

    public function dashboard()
    {
        return view('training.dashboard', ['decks' => Deck::current()]);
    }

    public function study(Deck $deck, string $typeTraining)
    {
        return view('training.' . $typeTraining, ['deck' => $deck]);
    }

    public function getWord(Deck $deck, Request $request): string
    {
        $this->init($deck, $request);
        $this->setLayout();

        return $this->sendResponse();
    }

    private function init(Deck $deck, Request $request): void
    {
        $this->lastId = Session::get('training.last_flashcard_id');

        $query = Flashcard::with('status');
        $query->where('deck_id', $deck->id);

        if ($deck->flashcards->count() > 1 && $this->lastId) {
            $query->whereNotIn('id', [$this->lastId]);
        }

        $this->flashcards = $query->get();
        $this->deck = $deck;
        $this->request = $request;
        $this->flashcard = $this->flashcards->slice($this->getIndex(), 1)->first();

        Session::put('training.last_flashcard_id', $this->flashcard->id);
    }

    private function getIndex()
    {
        $weights = arrayGet($this->flashcards->toArray(), 'status.weight');

        $randomPicker = new RandomPicker();
        $randomPicker->addElements($weights);

        return $randomPicker->getRandomElement();
    }

    protected function sendResponse(): string
    {
        return json_encode([
            'flashcard' => new FlashcardResource($this->flashcard),
            'layout' => $this->flashcardHtml,
            'deck' => $this->deck,
        ]);
    }

    protected function setLayout(): void
    {
        // abstract method
    }
}
