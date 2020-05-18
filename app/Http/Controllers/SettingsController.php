<?php

namespace App\Http\Controllers;

use App\Models\Settings;
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
        Settings::store($request->settings);

        return redirect(route('settings.index'));
    }

    /**
     * Обновление настроек пользователя откуда либо кроме страницы настроек
     */
    public function update(Request $request): JsonResponse
    {
        Settings::set($request->key, $request->value);

        return $this->respondSuccess();
    }

}
