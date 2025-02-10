<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ChurchResource\Pages;
use App\Filament\Admin\Resources\ChurchResource\RelationManagers;
use App\Models\Church;
use App\Models\City;
use App\Models\State;
use Filament\Facades\Filament;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

class ChurchResource extends Resource
{
    protected static ?string $model = Church::class;
    protected static int $idPanama = 170;
    protected static ?string $navigationLabel = 'Iglesias';
    protected static ?string $modelLabel = "Iglesia";
    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationGroup = 'Gestión del Sistema';

    public static function form(Form $form): Form
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
                            ->default(self::$idPanama)
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
                            ->onlyCountries(['PA']),
                    ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Iglesia')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('corregimiento.name') // Usamos 'corregimiento.name'
                    ->label('Corregimiento'),
                    Tables\Columns\TextColumn::make('pastor_name') // Usamos 'corregimiento.name'
                    ->label('Pastor Actual'),
                    PhoneColumn::make('phone')->label('Celular')->displayFormat(PhoneInputNumberType::NATIONAL),
                    Tables\Columns\ToggleColumn::make('active')->label('Activo'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChurches::route('/'),
            'create' => Pages\CreateChurch::route('/create'),
            'edit' => Pages\EditChurch::route('/{record}/edit'),
        ];
    }
}
