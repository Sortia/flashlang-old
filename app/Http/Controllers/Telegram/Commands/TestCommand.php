<?php

namespace App\Http\Controllers\Telegram\Commands;

use Telegram\Bot\Commands\Command;

class TestCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "user";

    /**
     * @var string Command Description
     */
    protected $description = "Test Command";

    public function handle()
    {
        $this->replyWithMessage(['text' => user()->id]);
    }
}
