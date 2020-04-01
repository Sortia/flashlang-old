<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends AuthController
{
    public function index()
    {
        return Socialite::driver('google')->redirect();
    }

    public function auth()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }

        // check if they're an existing user
        $user = User::on()->where('email', $googleUser->email)->first();

        if ( ! $user) {
            // create a new user
            $user            = new User;
            $user->name      = $googleUser->name;
            $user->email     = $googleUser->email;
            $user->google_id = $googleUser->id;
            $user->save();
        }

        auth()->login($user, true);

        return redirect()->to('/home');
    }
}
