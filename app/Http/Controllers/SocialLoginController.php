<?php

namespace App\Http\Controllers;

use App\Services\SocialAuthService;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    protected $socialAuthService;

    public function __construct(SocialAuthService $socialAuthService)
    {
        $this->socialAuthService = $socialAuthService;
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function socialCallback()
    {
        return $this->socialAuthService->handleGoogleCallback();
    }
}
