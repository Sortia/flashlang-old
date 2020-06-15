<?php

namespace App\Http\Controllers\Telegram\Commands;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Telegram\Bot\Laravel\Facades\Telegram;

trait ShouldAuth
{
    protected function authUser()
    {
        $telegramId = request()['message']['from']['id'];

        $user = User::where('telegram_id', $telegramId)->first();

        $this->maybeSendAuthError($user, $telegramId);

        Auth::login($user);
    }

    protected function maybeSendAuthError(?User $user, int $telegramId)
    {
        // If current user not tie with application account
        if (is_null($user)) {
            Telegram::sendMessage([
                'chat_id' => $telegramId,
                'text' => 'Pls auth. \\(*_*)/',
            ]);
            die();
        }
    }
}
