<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Exceptions\TelegramAuthException;
use App\Models\Flashcard;
use Illuminate\Support\Facades\Redis;
use Telegram\Bot\Commands\Command;

class TranslateCommand extends Command
{
    use Authenticable;
    /**
     * @var string Command Name
     */
    protected $name = "translate";

    /**
     * @var string Command Description
     */
    protected $description = "Translate previous word.";

    /**
     * Command handler
     *
     * @inheritDoc
     * @throws TelegramAuthException
     */
    public function handle()
    {
        $this->authUser();

        if ($flashcardId = Redis::get("user:" . user()->id . ":last_word")) {
            $flashcard = Flashcard::find($flashcardId);

            $this->replyWithMessage(['text' => $flashcard->getHiddenText()]);
        }

        $this->triggerCommand('training');
    }
}
