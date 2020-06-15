<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TelegramSettingsController extends Controller
{
    public function index()
    {
        return view('telegram.settings');
    }

    public function setup(): void
    {
        $token = config('telegram.bots.flashlang_bot.token');

        $response = Http::post("https://api.telegram.org/bot{$token}/setWebhook", [
            'url' => config('telegram.bots.flashlang_bot.webhook_url')
        ]);

        dd($response->body());
    }
}
