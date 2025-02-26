<?php

namespace App\Providers;

use App\Services\Contracts\SocialAuthProviderInterface;
use App\Services\GoogleAuthService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use BezhanSalleh\PanelSwitch\PanelSwitch;

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
      if (app()->environment('production')) {
          URL::forceScheme('https');
      }
      PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
        // Custom configurations go here
        $panelSwitch
        ->panels(['admin', 'app'])
        ->modalWidth('sm')
        ->slideOver()
        ->modalHeading('Paneles Disponibles')
        ->visible(fn (): bool => auth()->user()?->hasAnyRole([
            'super_admin',
        ]))
        ->icons([
          'admin' => 'heroicon-o-square-2-stack',
          'app' => 'heroicon-o-star',
      ])
        ->iconSize(16)
        ->labels([
            'admin' => 'Administrador',
            'app' => 'Personal'
        ]);
    });
  }
}
