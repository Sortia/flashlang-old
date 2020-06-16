<?php

namespace App\Http\Controllers\Telegram;

use CURLFile;

trait TelegramDocumentSender
{
    /**
     * @param array $params
     * @return bool|string
     */
    private function replyWithDocument(array $params)
    {
        $url = "https://api.telegram.org/bot{$this->getTelegram()->getAccessToken()}/sendDocument";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, [
            "chat_id" => $this->update->getChat()->id,
            "document" => new CURLFile($params['document']),
            "caption" => $params['caption'] ?? ""
        ]);

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }
}
