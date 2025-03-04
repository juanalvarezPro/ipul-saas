<?php

namespace App\Filament\Components\User;

use App\Enums\userStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class FormUser {

    public static function make(Form $form): Form
    {
        return $form
        ->schema(
            [
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(20),
                Select::make('status')
                    ->label('Estado')
                    ->options(userStatus::class)
                    ->default(userStatus::PENDING)
                    ->required(),
                Select::make('church_id')
                    ->label('Iglesia a la que se congrega')
                    ->relationship('church', 'name')
                    ->searchable()
                    ->optionsLimit(5)
                    ->preload()
                    ->required()
                    ->placeholder('Seleccione una iglesia'),

                TextInput::make('email')
                    ->label('Correo Corporativo')
                    ->email()
                    ->required(),
            ]
        );
    }
}