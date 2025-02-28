<?php

namespace App\Filament\Components\TransactionConcept;

use App\Enums\transactionStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;

class FormTransactionConcept
{
    public static function make(Form $form, $model): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')->label('Nombre')
                ->required()
                ->afterStateUpdated(fn($state, callable $set) => self::validateUniqueConcept($state, $set, $model)),
            Forms\Components\TextInput::make('description')->label('Descripción'),
            Forms\Components\Select::make('transaction_type')
                ->label('Movimiento')
                ->options(transactionStatus::class)
                ->default(transactionStatus::INCOME)
                ->required()
        ])
        ->columns(3);
    }

     /**
     * Valida si el nombre ingresado ya existe como concepto global.
     */
    private static function validateUniqueConcept($state, callable $set, $model): void
    {
        $state = trim(strtolower($state)); // Convertir a minúsculas y eliminar espacios
        $set('name', $state); // Actualizar el estado del input

        // Verificar si ya existe como concepto global
        $existsGlobalConcept = $model::where('name', $state)
            ->where('is_global', true)
            ->exists();

        if ($existsGlobalConcept) {
            $set('name', ''); // Limpiar el campo

            Notification::make()
                ->title('Error')
                ->body('El nombre no puede ser igual a un concepto global.')
                ->danger()
                ->send();
        }
    }
}
