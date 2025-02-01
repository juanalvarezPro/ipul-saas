<?php

namespace App\Listeners;

use SocialiteProviders\Google\Provider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class GoogleLoginProvider
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SocialiteWasCalled $event): void
    {
        $event->extendSocialite('google', Provider::class);
    }
}
