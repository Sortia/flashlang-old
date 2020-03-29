<?php

namespace App\Http\Controllers;

use App\Repositories\SettingsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    private SettingsRepository $repository;

    /**
     * SettingsController constructor.
     */
    public function __construct(SettingsRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Страница настроек
     */
    public function index(): View
    {
        $settings = $this->repository->all();

        return view('settings', compact('settings'));
    }

    /**
     * Обновление настроек пользователя со страницы настроек
     */
    public function store(Request $request): RedirectResponse
    {
        $this->repository->store($request->settings);

        return redirect(route('settings.index'));
    }

    /**
     * Обновление настроек пользователя откуда либо кроме страницы настроек
     */
    public function update(Request $request): JsonResponse
    {
        $this->repository->set($request->key, $request->value);

        return $this->respondSuccess();
    }

}
