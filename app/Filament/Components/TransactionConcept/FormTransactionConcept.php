<?php

namespace App\Filament\Components\TransactionConcept;

use App\Enums\transactionStatus;
use App\Models\TransactionConcepts;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Closure;

class FormTransactionConcept
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255)
                    ->rule(static function (Forms\Get $get, Forms\Components\Component $component): Closure {
                        return static function (string $attribute, $value, Closure $fail) use ($get, $component) {
                
                            $existsConcept = TransactionConcepts::whereRaw("unaccent(lower(name)) = unaccent(lower(?))", [$value])
                                ->where(function ($query) {
                                    $query->where('is_global', true)
                                        ->orWhere('church_id', Auth::user()->church_id);
                                })
                                ->first();

                            if ($existsConcept && $existsConcept->getKey() !== $component->getRecord()?->getKey()) {
                                $fail("El nombre \"{$value}\" ya existe como concepto global o dentro de tu iglesia.");
                            }
                        };
                    }),
                Forms\Components\TextInput::make('description')->label('Descripción'),
                Forms\Components\Select::make('transaction_type')
                    ->label('Movimiento')
                    ->options(transactionStatus::class)
                    ->default(transactionStatus::INCOME)
                    ->required()
            ])
            ->columns(3);
    }
}
