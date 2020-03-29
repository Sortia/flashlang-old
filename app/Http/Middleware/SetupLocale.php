<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetupLocale
{
    /**
     * Задание языка интерфейса
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        App::setLocale(settings('locale', 'en'));

        return $next($request);
    }
}
