<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TelegramAuthController extends Controller
{
    /**
     * Обработка входа через телеграм
     */
    public function auth(Request $request): RedirectResponse
    {
        // check if they're an existing user
        $user = User::where('telegram_id', $request->id)->first();

        if (!$user) {
            // create a new user
            $user = new User;
            $user->name = $request->first_name . ' ' . $request->second_name;
            $user->telegram_id = $request->id;
            $user->save();
        }

        auth()->login($user, true);

        return redirect()->to('/home');
    }

    /**
     * Праставляю текущему пользователю id'шник телеги
     */
    public function connect(Request $request): RedirectResponse
    {
        user()->update(['telegram_id' => $request->id]);

        return redirect()->to('/home');
    }
}
