<?php

namespace App\Filament\Components\Transaction;

use App\Filament\Components\TransactionConcept\FormTransactionConcept;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms;
use Illuminate\Support\Str;
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
                    ->relationship('transactionConcept', 'name', fn(Builder $query) => $query->where('active', true))
                    ->label('Concepto')
                    ->searchable()
                    // ->getSearchResultsUsing(fn(string $search): array => FormTransactionConcept::searchTransactionConcepts($search))
                    // ->getOptionLabelUsing(fn($value): ?string => FormTransactionConcept::getTransactionConceptLabel($value))
                    ->createOptionForm([
                        FormTransactionConcept::nameField(),
                        FormTransactionConcept::parentSelect(),
                        FormTransactionConcept::transactionTypeSelect(),
                    ])
                    ->createOptionUsing(function (array $data): int {

                        return FormTransactionConcept::createTransactionConcept($data);
                    })
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
                    ->directory(fn() => 'transactions-attachments/' . Str::slug(auth()->user()->church->name ?? 'default'))
                    ->previewable()
                    ->downloadable()
                    ->columnSpanFull(),
            ])->columns(3);
    }
}
