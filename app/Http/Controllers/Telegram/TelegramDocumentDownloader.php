<?php

namespace App\Http\Controllers\Telegram;

use Illuminate\Support\Facades\Http;

trait TelegramDocumentDownloader
{
    /**
     * Get attached file
     */
    private function getMessageDocument(): string
    {
        $fileId = $this->getUpdate()->getMessage()->document->fileId;

        return $this->getDocumentByFileId($fileId);
    }

    /**
     * Get file by id
     */
    private function getDocumentByFileId($fileId): string
    {
        $token = $this->getTelegram()->getAccessToken();

        $filePath = $this->telegram->getFile(['file_id' => $fileId])->filePath;

        return Http::get("https://api.telegram.org/file/bot{$token}/{$filePath}")->body();
    }
}
