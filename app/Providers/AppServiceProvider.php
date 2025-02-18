<?php

namespace App\Providers;

use App\Services\Contracts\SocialAuthProviderInterface;
use App\Services\GoogleAuthService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void {
    $this->app->bind(SocialAuthProviderInterface::class, GoogleAuthService::class);
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    //  URL::forceScheme('https');

  }
}
