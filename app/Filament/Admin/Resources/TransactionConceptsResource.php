<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TransactionConceptsResource\Pages;
use App\Filament\Base\BaseTransactionConcept;


class TransactionConceptsResource extends BaseTransactionConcept
{

    protected static ?string $navigationLabel = 'Conceptos Globales';

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactionConcepts::route('/'),
            'create' => Pages\CreateTransactionConcepts::route('/create'),
            'edit' => Pages\EditTransactionConcepts::route('/{record}/edit'),
        ];
    }
}
