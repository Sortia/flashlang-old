<?php

namespace App\Http\Controllers\Telegram;

use Illuminate\Support\Facades\Http;

trait TelegramDocumentSender
{
    /**
     * Отправка документа в телеграм.
     * Переопределение стандартной функции, т. к. та почему-то не работает.
     *
     * @return bool|string
     */
    private function replyWithDocument(array $params)
    {
        return Http::attach(
            'document', file_get_contents($params['document']), $params['document']
        )->post("https://api.telegram.org/bot{$this->getTelegram()->getAccessToken()}/sendDocument", [
            "chat_id" => $this->update->getChat()->id,
            "caption" => $params['caption'] ?? ""
        ]);
    }
}
