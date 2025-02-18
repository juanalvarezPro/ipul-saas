<?php

namespace App\Services\Contracts;



interface SocialAuthProviderInterface
{
    public function getUser();
    public function redirect();
}