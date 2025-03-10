<?php

namespace App\Filament\Components\Church;

use App\Models\City;
use App\Models\State;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\Collection;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

class FormChurch {
    protected static int $IDPANAMA = 170; //ID TABLE COUNTRIES

    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                // Sección: Datos de la Iglesia
                Forms\Components\Section::make('Nombre de la Iglesia')
                ->description('Recomendamos poner antes del nombre las siglas IPUL')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre')
                            ->default('IPUL ')
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255),
                    ]),

                // Sección: Dirección
                Forms\Components\Section::make('Dirección')
                    ->columns(4)
                    ->schema([
                        Forms\Components\Select::make('country_id')
                            ->relationship('country', 'name')
                            ->label('País')
                            ->default(self::$IDPANAMA)
                            ->afterStateUpdated(function (Set $set) {
                                $set('state_id', null);
                                $set('city_id', null);
                            })
                            ->required(),

                        Forms\Components\Select::make('province_id')
                        ->label('Provincia')
                            ->options(fn(Get $get): Collection => State::query()
                                ->where('country_id', $get('country_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn(Set $set) => $set('city_id', null))
                            ->required(),
                        Forms\Components\Select::make('corregimiento_id')
                        ->label('Corregimiento')
                            ->options(fn(Get $get): Collection => City::query()
                                ->where('state_id', $get('province_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('street_address')
                            ->label('Dirección')
                            ->required()
                            ->maxLength(255),
                    ]),

                // Sección: Datos del Pastor
                Forms\Components\Section::make('Datos del Pastor')
                ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('pastor_name')
                            ->label('Nombre del Pastor')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->nullable(),
                            PhoneInput::make('phone')
                            ->label('Número de Celular')
                            ->defaultCountry('PA')
                            ->unique(ignoreRecord: true)
                            ->onlyCountries(['PA'])
                            ->focusNumberFormat(PhoneInputNumberType::E164)
                            ->regex('/^\+5076\d{7}$/', 'El número debe comenzar con +5076 y tener 8 dígitos en total')
                    ]),
            ]);
    
    }

}