<?php

namespace App\Http\Controllers;

use App\Settings;
use App\UserSettings;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Страница настроек
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('settings', [
            'settings' => Settings::with('values')->get(),
        ]);
    }

    /**
     * Обновление настроек пользователя со страницы настроек
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
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
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        return response()->json(set_settings($request->key, $request->value));
    }

    /**
     * Инициализация настроек для нового пользователя
     *
     * @param $userId
     * @return void
     */
    public static function setDefaults($userId): void
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
