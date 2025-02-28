<?php

namespace App\Filament\Components\Transaction;

class SearchTransaction
{

    public static function searchableAttributes(): array
    {
        return ['user.name', 'transactionConcept.name', 'amount'];
    }

    public static function searchResultDetails($record): array
    {
        return [
            'Usuario' => $record->user->name,
            'Monto' => $record->amount,
            'Concepto' => optional($record->transactionConcept)->name,
        ];
    }
}
