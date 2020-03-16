<?php

namespace App\Http\Controllers;

use App\Settings;
use App\UserSettings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings', [
            'settings' => Settings::with('values')->get(),
        ]);
    }

    public function store(Request $request)
    {
        foreach ($request->settings as $key => $value) {
            UserSettings::on()->updateOrCreate([
                'user_id' => user()->id,
                'settings_id' => Settings::on()->where('name', $key)->value('id')
            ],[
                'settings_value_id' => $value
            ]);
        }

        return redirect(route('settings.index'));
    }

    public function update(Request $request)
    {
        return response()->json(settings($request->key, $request->value));
    }
}
