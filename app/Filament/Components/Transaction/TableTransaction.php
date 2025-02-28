<?php

namespace App\Filament\Components\Transaction;

use Filament\Tables;
use Filament\Tables\Table;

class TableTransaction
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('amount')
                    ->label('Monto')
                    ->sortable()
                    ->money('PAB')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transactionConcept.name')
                    ->label('Conceptos')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('transactionConcept.transaction_type')
                    ->label('Movimientos')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Usuario')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descripción')
                    ->sortable()
                    ->searchable()
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('transaction_date')
                    ->label('Fecha del Movimiento')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
