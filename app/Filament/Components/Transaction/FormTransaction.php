<?php

namespace App\Filament\Components\Transaction;

use Filament\Forms;
use Filament\Forms\Form;

class FormTransaction
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('amount')
                    ->label('Monto')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('concept_id')
                    ->relationship('transactionConcept', 'name')
                    ->label('Concepto')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\DatePicker::make('transaction_date')
                    ->label('Fecha del Movimiento')
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->label('Descripción (opcional)')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('attachments')
                    ->label('Archivos adjuntos (opcional)')
                    ->openable()
                    ->multiple()
                    ->disk('r2')
                    ->visibility('private')
                    ->directory('transactions-attachments')
                    ->previewable()
                    ->downloadable()
                    ->columnSpanFull(),
            ])->columns(3);
    }
}
