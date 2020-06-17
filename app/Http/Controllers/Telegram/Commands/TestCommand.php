<?php

namespace App\Http\Controllers\Telegram\Commands;

use Telegram\Bot\Commands\Command;

class TestCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "im";

    /**
     * @var string Command Description
     */
    protected $description = "Show your id";

    /**
     * Command handler
     *
     * @inheritDoc
     */
    public function handle()
    {
        $this->replyWithMessage(['text' => user()->id]);
    }
}
