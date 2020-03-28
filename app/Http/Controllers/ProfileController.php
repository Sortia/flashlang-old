<?php

namespace App\Http\Controllers;

use App\Http\Services\ProfileService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Страница профиля
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('profile', ['user' => user()]);
    }

    /**
     * Сохранение данных профиля пользователя
     *
     * @param  Request  $request
     *
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        ProfileService::handleUploadedImage($request->file('avatar'));

        return redirect(route('profile'));
    }
}
