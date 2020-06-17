<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TelegramSettingsController extends Controller
{
    public function setup(): void
    {
        $token = config('telegram.bots.flashlang_bot.token');
        $url = config('telegram.bots.flashlang_bot.webhook_url');

        $response = Http::post("https://api.telegram.org/bot{$token}/setWebhook", ['url' => $url]);

        dd($response->body());
    }
}
