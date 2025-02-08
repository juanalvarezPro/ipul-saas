<?php
namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseAuth;
use Filament\Actions\Action;

class LoginGoogle extends BaseAuth
{
    /**
     * Define el formulario de autenticación.
     * En este caso, se sobrescribe para eliminar los campos predeterminados.
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([]) // Se deja el esquema vacío para ocultar los campos de entrada tradicionales.
            ),
        ];
    }

    /**
     * Oculta la acción de autenticación predeterminada de Filament.
     */
    protected function getAuthenticateFormAction(): Action
    {
        return Action::make('authenticate')
            ->hidden(); // Se oculta la acción de autenticación tradicional.
    }
    
    /**
     * Define las acciones disponibles en el formulario de login.
     * Aquí se agrega un botón para iniciar sesión con Google.
     */
    protected function getFormActions(): array
    {
        return [
            $this->getAuthenticateFormAction(), // Se incluye la acción de autenticación oculta.
            Action::make('loginWithGoogle')
                ->label('Iniciar Sesión con Google') // Texto del botón.
                ->color('primary') // Color del botón.
                ->url(route('auth.google')), // Redirige a la ruta de autenticación con Google.
        ];
    }
}
