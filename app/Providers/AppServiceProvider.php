<?php

namespace App\Providers;

use App\Services\Contracts\SocialAuthProviderInterface;
use App\Services\FilamentHookService;
use App\Services\GoogleAuthService;
use App\Services\PanelSwitchService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->bind(SocialAuthProviderInterface::class, GoogleAuthService::class);
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    if (app()->environment('production')) {
      URL::forceScheme('https');
    }

    PanelSwitchService::configure();
    FilamentHookService::register();
  }
}
