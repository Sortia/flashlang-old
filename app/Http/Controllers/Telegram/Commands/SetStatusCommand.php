<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Models\Flashcard;
use Telegram\Bot\Commands\Command;

class SetStatusCommand extends Command
{
    use ShouldAuth;

    /**
     * @var string Command Name
     */
    protected $name = "set_status";

    protected $pattern = '{flashcardText} {value}';

    /**
     * @var string Command Description
     */
    protected $description = "Set user settings. Example: /set_settings locale en";

    public function __construct()
    {
        $this->authUser();
    }

    public function handle()
    {
        $arguments = $this->getArguments();

        Flashcard::with('status')->my()
            ->where('front_text', $arguments['flashcardText'])
            ->orWhere('back_text', $arguments['flashcardText'])
            ->update(['status_id' => $arguments['value']]);
    }
}

