<?php

namespace App\Filament\Components\Church;

use Filament\Tables;
use Filament\Tables\Table;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

class TableChurch
{
    public static function make(Table $table): Table
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
                PhoneColumn::make('phone')->label('Celular')->displayFormat(PhoneInputNumberType::E164),
                Tables\Columns\ToggleColumn::make('active')->label('Activo'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
