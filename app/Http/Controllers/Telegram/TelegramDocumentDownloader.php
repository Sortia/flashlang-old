<?php

namespace App\Http\Controllers\Telegram;

use Illuminate\Support\Facades\Http;

trait TelegramDocumentDownloader
{
    /**
     * Получение файла, прикрепленного к сообщению
     */
    private function getFile()
    {
        $token = $this->getTelegram()->getAccessToken();
        $fileId = $this->getUpdate()->getMessage()->document->fileId;
        $filePath = $this->telegram->getFile(['file_id' => $fileId])->filePath;

        return Http::get("https://api.telegram.org/file/bot{$token}/$filePath")->body();
    }
}
