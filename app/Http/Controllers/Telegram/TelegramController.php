<?php

namespace App\Http\Controllers\Telegram;

use App\Exceptions\TelegramAuthException;
use App\Exceptions\TelegramException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class TelegramController
{
    /**
     * Обработка вебхука
     *
     * @param Request $request
     * @throws Exception
     */
    public function handler(Request $request)
    {
        try {
            $commandsHandler = Telegram::commandsHandler(true);

            $this->handleMessage($request, $commandsHandler);
            $this->handleUploadDocument($request, $commandsHandler);
        } catch (TelegramException $e) {
            Telegram::sendMessage([
                'parse_mode' => 'html',
                'chat_id' => $request['message']['from']['id'],
                'text' => $e->getMessage()
            ]);
        } catch (Exception $e) {
            print_r($e->getMessage()); die;
        }
    }

    /**
     * Обработка обычных сообщений пользователя (не команд)
     */
    private function handleMessage(Request $request, Update $update): void
    {
        if (!isset($request['message']['text']))
            return;

        $message = Str::lower($request['message']['text']);

        // С помощью этой фигни эмулируется вызов команд обычной строкой.
        // То есть сообщение "Help" вызовет команду /help и т. д.
        // Сделано, чтобы команды вызывались нажатием кнопки
        if (array_search($message, array_keys(Telegram::getCommands()))) {
            Telegram::triggerCommand($message, $update);
        }
    }

    /**
     * Обработка отправки документа
     */
    private function handleUploadDocument(Request $request, Update $update): void
    {
        if (!isset($request['message']['caption_entities']))
            return;

        $command = Str::after($request['message']['caption'], '/');

        // Обработка команды, если она идет вместе с прикрепленным файлом.
        // Просто из коробки такое почему-то не поддерживается =(
        if (array_search($command, array_keys(Telegram::getCommands()))) {
            Telegram::triggerCommand($command, $update);
        }
    }
}
