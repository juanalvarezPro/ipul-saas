<?php

namespace App\Filament\Components\User;

class SearchUser
{
    public static function searchableAttributes(): array
    {
        return ['name', 'church.name'];
    }

    public static function searchResultDetails($record): array
    {
        return [
            'Nombre' => $record->name,
            'Iglesia' => $record->church->name,
        ];
    }
}
