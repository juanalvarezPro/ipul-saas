<?php

namespace App\Services;

use App\Services\Contracts\SocialAuthProviderInterface;
use Laravel\Socialite\Facades\Socialite;


class GoogleAuthService implements SocialAuthProviderInterface
{
    public function getUser()
    {
        return Socialite::driver('google')->user();
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
}
