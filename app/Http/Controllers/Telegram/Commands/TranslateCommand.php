<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Models\Flashcard;
use Illuminate\Support\Facades\Redis;
use Telegram\Bot\Commands\Command;

class TranslateCommand extends Command
{
    use ShouldAuth;
    /**
     * @var string Command Name
     */
    protected $name = "translate";

    /**
     * @var string Command Description
     */
    protected $description = "Translate previous word.";

    public function __construct()
    {
        $this->authUser();
    }

    public function handle()
    {
        if ($flashcardId = Redis::get("user:" . user()->id . ":last_word")) {
            $flashcard = Flashcard::find($flashcardId);

            $this->replyWithMessage(['text' => $flashcard->front_text]);
        }

        $this->triggerCommand('training');
    }

}
