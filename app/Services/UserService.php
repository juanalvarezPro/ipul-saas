<?php

namespace App\Services;

use App\Models\User;
use App\Enums\userStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Two\User as SocialUser;

class UserService
{
    public function findOrCreateUser(SocialUser $socialUser): User
    {
        return User::firstOrCreate(
            ['email' => $socialUser->getEmail()],
            [
                'name' => $socialUser->getName(),
                'email_verified_at' => now(),
                'avatar' => $socialUser->getAvatar(),
                'password' => Hash::make(uniqid()),
                'status' => userStatus::PENDING,
            ]
        );
    }

    public function authenticateUser(User $user)
    {
        if (($user->status != userStatus::APPROVED) || ($user->church_id === null)) {
            Auth::logout();
            return redirect('/pending-approval');
        }

        Auth::login($user);
        return redirect('/app');
    }
}
