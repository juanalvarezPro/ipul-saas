<?php

namespace App\Filament\Components\Church;

class SearchChurch
{

    public static function searchableAttributes(): array
    {
        return ['name'];
    }

    public static function searchResultDetails($record): array
    {
        return [
            'Iglesia' => $record->name,
            'Pastor' => $record->pastor_name,
            'Celular' => $record->phone,
        ];
    }
}
