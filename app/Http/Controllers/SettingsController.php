<?php

namespace App\Http\Controllers;

use App\Settings;
use App\UserSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Страница настроек
     */
    public function index(): View
    {
        return view('settings', ['settings' => Settings::with('values')->get()]);
    }

    /**
     * Обновление настроек пользователя со страницы настроек
     */
    public function store(Request $request): RedirectResponse
    {
        foreach ($request->settings as $key => $value) {
            UserSettings::on()->updateOrCreate([
                'user_id' => user()->id,
                'settings_id' => Settings::on()->where('name', $key)->value('id')
            ], [
                'settings_value_id' => $value
            ]);
        }

        return redirect(route('settings.index'));
    }

    /**
     * Обновление настроек пользователя откуда либо кроме страницы настроек
     */
    public function update(Request $request): JsonResponse
    {
        return response()->json(set_settings($request->key, $request->value));
    }

    /**
     * Инициализация настроек для нового пользователя
     */
    public static function setDefaults(int $userId): void
    {
        $settings = Settings::all();

        foreach ($settings as $setting) {
            UserSettings::on()->create([
                'settings_id' => $setting->id,
                'user_id' => $userId,
                'settings_value_id' => $setting->values->first()->id
            ]);
        }
    }
}
