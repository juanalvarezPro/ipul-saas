<?php

namespace App\Filament\Components\User;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use App\Enums\userStatus;

class TableUser
{
    protected static ?string $unassignedChurch = 'Sin Asignar';
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_personal')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('church.name')
                    ->label('Iglesia')
                    ->searchable()
                    ->getStateUsing(fn($record) => $record->church?->name ?? self::$unassignedChurch)
                    ->badge()
                    ->color(fn($state) => $state === self::$unassignedChurch ? 'gray' : 'info'),

                Tables\Columns\TextColumn::make('status')->label('Estado')->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        Grid::make(2) // Se usa Grid en lugar de columns()
                            ->schema([
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
                                Forms\Components\Select::make('roles')
                                    ->relationship('roles', 'name')
                                    ->preload(),
                            ]),
                    ]),

                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    // ...
                ]),
            ]);
    }
}
