<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Http\Services\TrainingService;
use App\Models\Flashcard;
use Exception;
use Telegram\Bot\Commands\Command;

class TrainingCommand extends Command
{
    use Authenticable;

    /**
     * @var string Command Name
     */
    protected $name = "training";

    /**
     * @var string Command Description
     */
    protected $description = "Training Command";

    /**
     * @var TrainingService
     */
    private TrainingService $service;

    /**
     * TrainingCommand constructor.
     */
    public function __construct(TrainingService $service)
    {
        $this->service = $service;
    }

    /**
     * Command handler
     *
     * @inheritDoc
     * @throws Exception
     */
    public function handle()
    {
        $this->authUser();
        $this->sendNextWord();
    }

    /**
     * @throws Exception
     */
    private function sendNextWord()
    {
        $flashcard = $this->service->getTrainingFlashcard(Flashcard::my()->get());

        $this->replyWithMessage(['text' => $flashcard->getShowText()]);
    }
}
