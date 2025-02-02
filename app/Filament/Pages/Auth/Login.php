<?php
namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseAuth;
use Filament\Actions\Action;

class Login extends BaseAuth
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([])
            ),
        ];
    }

    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('authenticate')
            ->hidden();
            
    }
    

    protected function getFormActions(): array
    {
        return [
            $this->getAuthenticateFormAction(),
            Action::make('loginWithGoogle')
                ->label('Iniciar Sesión con Google')
                ->color('primary')
                ->url(route('auth.google')),
        ];
    }
    
}
