<?php

namespace App\Http\Controllers;

use App\Services\SocialAuthService;

class SocialLoginController extends Controller
{
    protected $socialAuthService;

    public function __construct(SocialAuthService $socialAuthService)
    {
        $this->socialAuthService = $socialAuthService;
    }

    public function redirectToProvider()
    {
        return $this->socialAuthService->handleRedirect();
    }

    public function socialCallback()
    {
        return $this->socialAuthService->handleCallback();
    }
}
