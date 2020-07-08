<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Http\Services\TrainingService;
use App\Models\Flashcard;
use App\Models\Storybook;
use Exception;
use Telegram\Bot\Commands\Command;

class ReadingTrainingCommand extends Command
{
    use Authenticable;

    /**
     * @var string Command Name
     */
    protected $name = "reading";

    /**
     * @var string Command Description
     */
    protected $description = "Reading training";

    /**
     * @var TrainingService
     */
    private TrainingService $service;

    /**
     * FlashcardTrainingCommand constructor.
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
        $this->sendStorybook();
    }

    /**
     * @throws Exception
     */
    private function sendStorybook()
    {
        $words = Flashcard::my()->get()->implode('front_text', ' ');

        $storybook = Storybook::searchByQuery(['match' => ['text' => $words]], null, null, 20)->random();

        $this->replyWithMessage(['text' => $storybook->text]);
    }
}
