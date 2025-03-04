<?php

namespace App\Filament\Components\TransactionConcept;

use App\Enums\transactionStatus;
use App\Models\TransactionConcepts;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class FormTransactionConcept
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Nombre')
                    ->required()
                    ->afterStateUpdated(fn($state, callable $set) => self::validateUniqueConcept($state, $set)),
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
     * Valida si el nombre ingresado ya existe como concepto global o como concepto para el mismo church_id.
     */
    protected static function validateUniqueConcept($state, callable $set): void
    {
        $state = trim(strtolower($state)); // Convertir a minúsculas y eliminar espacios
        $set('name', $state);

        // Verificar si el concepto ya existe, ya sea como concepto global o específico para la iglesia
        $existsConcept = TransactionConcepts::where('name', $state)
            ->where(function ($query) {
                $query->where('is_global', true)
                    ->orWhere('church_id', Auth::user()->church_id);
            })
            ->exists();

        if ($existsConcept) {
            $set('name', '');

            Notification::make()
                ->title('Error')
                ->body('El nombre ya existe como concepto global o dentro de tu iglesia.')
                ->danger()
                ->send();
        }
    }
}
