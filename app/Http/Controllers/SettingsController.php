<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function store(Request $request)
    {
        return response()->json(settings($request->key, $request->value));
    }
}
