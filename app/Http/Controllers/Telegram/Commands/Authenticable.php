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
            $settingsUrl = route('settings.index');

            throw new TelegramAuthException("Pls <a href='{$settingsUrl}'>connect telegram to your account</a> or /create_account");
        }

        Auth::login($user);
    }
}
