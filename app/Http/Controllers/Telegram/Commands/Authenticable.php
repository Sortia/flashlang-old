<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Exceptions\TelegramAuthException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait Authenticable
{
    /**
     * @throws TelegramAuthException
     */
    protected function authUser()
    {
        $telegramId = request()['message']['from']['id'];

        $user = User::where('telegram_id', $telegramId)->first();

        if (is_null($user)) {
            throw new TelegramAuthException('Pls auth. \\(*_*)/');
        }
        Auth::login($user);
    }
}
