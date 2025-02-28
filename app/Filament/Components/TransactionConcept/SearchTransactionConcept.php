<?php

namespace App\Filament\Components\TransactionConcept;

class SearchTransactionConcept
{
    public static function searchableAttributes(): array
    {
        return ['user.name', 'name'];
    }

    public static function searchResultDetails($record): array
    {
        return [
            'Nombre' => $record->name,
            'Usuario' => $record->user->name,
        ];
    }
}
