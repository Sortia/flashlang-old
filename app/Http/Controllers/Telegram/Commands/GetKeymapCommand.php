<?php

namespace App\Http\Controllers\Telegram\Commands;

use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class GetKeymapCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "get_keymap";

    /**
     * @var string Command Description
     */
    protected $description = "Get keymap";

    /**
     * Command handler
     *
     * @inheritDoc
     */
    public function handle()
    {
        $this->replyWithMessage([
            'text' => 'Держи удобные кнопки, чтобы не писать команды',
            'reply_markup' => $this->getKeymap(),
        ]);
    }

    public function getKeymap()
    {
        return Keyboard::make([
            'keyboard' => [['Translate', 'Training']],
            'resize_keyboard' => true,
        ]);
    }
}
