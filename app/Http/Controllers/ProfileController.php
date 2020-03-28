<?php

namespace App\Http\Controllers;

use App\Http\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    private ProfileService $profileService;

    /**
     * ProfileController constructor.
     */
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Страница профиля
     */
    public function index(): View
    {
        return view('profile', ['user' => user()]);
    }

    /**
     * Сохранение данных профиля пользователя
     */
    public function store(Request $request): RedirectResponse
    {
        $this->profileService->handleUploadedImage($request->file('avatar'));

        return redirect(route('profile'));
    }
}
