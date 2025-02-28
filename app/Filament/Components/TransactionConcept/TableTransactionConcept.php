<?php

namespace App\Filament\Components\TransactionConcept;

use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TableTransactionConcept
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('transaction_type')
                    ->label("Comportamiento")
                    ->badge(),
                Tables\Columns\ToggleColumn::make('active')->label('Activo')
                    ->disabled(fn($record) => $record->user_id !== Auth::id())
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->searchable(),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->disabled(fn($record) => $record->user_id !== Auth::id()),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn($record) => $record->user_id === Auth::id()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
