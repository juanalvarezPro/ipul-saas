<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Workspace;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Support\Facades\Auth;

class RegisterWorkspace extends RegisterTenant
{
public static function getLabel(): string
{
    return 'Registrar Workspace';
}

public function form(Form $form): Form
{ 
    return $form
    ->schema([
        Section::make('¿Qué es un Workspace?') // Título llamativo
            ->description('Un workspace es un área dedicada a gestionar, registrar o coordinar proyectos específicos dentro de la iglesia.')
            ->schema([
                TextInput::make('name')
                    ->label('Nombre del Workspace')
                    ->required()
                    ->maxLength(15)
                    ->placeholder('Ejemplo: Contabilidad, Ministerio de Música, Eventos, etc.') // Ejemplos más específicos
                    ->helperText('Este campo tiene como valor predeterminado "General", pero puedes personalizarlo.') // Explicación clara
                    ->default('General'),
            ]),
    ]);

}

 protected function handleRegistration(array $data): Workspace
    {
        $workspace = Workspace::create($data);
        $user = Auth::user();
        
        // Asociar el usuario al workspace
        $workspace->members()->attach($user);

        return $workspace;
    }
    

}
