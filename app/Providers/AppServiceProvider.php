<?php

namespace App\Providers;

use App\Listeners\InvalidatePreviousSessions;
use App\Listeners\GoogleLoginProvider;
use App\Listeners\NotifyOnNewDeviceLogin;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Google\Provider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    //    URL::forceScheme('https'); 
      Event::listen(GoogleLoginProvider::class);
      Event::listen(Login::class, NotifyOnNewDeviceLogin::class);
    
    }
}
