<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\UserSettings;
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
        $settings = Settings::all();

        return view('settings', compact('settings'));
    }

    /**
     * Обновление настроек пользователя со страницы настроек
     */
    public function store(Request $request): RedirectResponse
    {
        foreach ($request->settings as $id => $value) {
            $this->setSetting($id, $value);
        }

        return redirect(route('settings.index'));
    }

    /**
     * Обновление настроек пользователя откуда либо кроме страницы настроек
     */
    public function flashStore(Request $request): JsonResponse
    {
        $this->setSetting($request->settings_id, $request->settings_value_id);

        return $this->respondSuccess();
    }

    /**
     * Сохранение настройки для аутентифицированного пользователя
     *
     * @param $settingsId
     * @param $settingsValueId
     */
    private function setSetting($settingsId, $settingsValueId)
    {
        UserSettings::on()->updateOrCreate([
            'settings_id' => $settingsId,
            'user_id' => user()->id,
        ], [
            'settings_value_id' => $settingsValueId,
        ]);
    }
}
