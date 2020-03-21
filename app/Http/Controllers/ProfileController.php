<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile', ['user' => user()]);
    }

    public function store(Request $request)
    {
        if ($request->has('avatar')) {
            user()->update([
                'avatar_path' => $request->file('avatar')->store('public/images')
            ]);
        }

        return redirect(route('profile'));
    }
}
