<?php

namespace App\Services;

use App\Enums\userStatus;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SocialAuthService
{
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'email_verified_at' => now(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => Hash::make($googleUser->getId()),
                    'status' => userStatus::PENDING,
                ]
            );
            if ($user->status != userStatus::APPROVED) {
                return redirect('/pending-approval');
            }

            Auth::login($user);

            return redirect('/app');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Error al autenticar con Google');
        }
    }
}
