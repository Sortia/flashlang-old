<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TelegramAuthController extends Controller
{
    /**
     * Обработка входа через телеграм
     */
    public function auth(Request $request): void
    {
        $this->tieUser($request->id);
    }

    /**
     * Праставляю текущему пользователю id'шник телеги
     */
    private function tieUser(int $telegramId): void
    {
        user()->update(['telegram_id' => $telegramId]);
    }

}
