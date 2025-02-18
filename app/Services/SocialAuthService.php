<?php

namespace App\Services;

use App\Services\Contracts\SocialAuthProviderInterface;
use App\Services\UserService;

class SocialAuthService
{
    protected $provider;
    protected $userService;

    public function __construct(SocialAuthProviderInterface $provider, UserService $userService)
    {
        $this->provider = $provider;
        $this->userService = $userService;
    }

    public function handleRedirect() {
        return $this->provider->redirect();
    }

    public function handleCallback()
    {
        try {
            $socialUser = $this->provider->getUser();
            $user = $this->userService->findOrCreateUser($socialUser);
            return $this->userService->authenticateUser($user);
        } catch (\Exception $e) {
            return redirect('/app/login')->with('error', 'Error al autenticar con Google');
        }
    }
}
