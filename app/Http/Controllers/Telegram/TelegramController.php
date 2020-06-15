<?php

namespace App\Http\Controllers\Telegram;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class TelegramController
{
    /**
     * @param Request $request
     * @throws Exception
     */
    public function handler(Request $request)
    {
        $commandsHandler = Telegram::commandsHandler(true);

        $this->handleMessage($request, $commandsHandler);
    }

    private function handleMessage(Request $request, Update $update)
    {
        $message = Str::lower($request['message']['text']);

        // С помощью этой фигни эмулируется вызов команд обычной строкой.
        // То есть сообщение "Help" вызовет команду /help и т. д.
        // Сделано, чтобы команды вызывались нажатием кнопки
        if (array_search($message, array_keys(Telegram::getCommands()))) {
            Telegram::triggerCommand($message, $update);
        }
    }
}
