<?php

namespace App\Filament\Pages;

use Filament\Pages\SimplePage;
use Filament\Actions\Action;
use Filament\Facades\Filament;

class PendingApproval extends SimplePage
{
    protected static string $view = 'filament.pages.pending-approval';
    protected static bool $shouldRegisterNavigation = false;

    public static function registerNavigationItems(): void
    {
        return;
    }

    public function getTitle(): string
    {
        return __('¡Cuenta en Revisión!');
    }

    public function logout()
    {
        Filament::auth()->logout();
        return redirect()->route('filament.app.auth.login');
    }
}
