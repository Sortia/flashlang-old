<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Http\Services\TrainingService;
use App\Models\Flashcard;
use Exception;
use Telegram\Bot\Commands\Command;

class TrainingCommand extends Command
{
    use ShouldAuth;

    /**
     * @var string Command Name
     */
    protected $name = "training";

    /**
     * @var string Command Description
     */
    protected $description = "Training Command";

    private TrainingService $service;

    public function __construct(TrainingService $service)
    {
        $this->authUser();

        $this->service = $service;
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        $this->sendNextWord();
    }

    /**
     * @throws Exception
     */
    private function sendNextWord()
    {
        $flashcard = $this->service->getTrainingFlashcard(Flashcard::my(user())->get());

        $this->replyWithMessage(['text' => $flashcard->back_text]);
    }
}
