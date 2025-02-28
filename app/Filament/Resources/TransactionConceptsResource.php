<?php

namespace App\Filament\Resources;

use App\Filament\Base\BaseTransactionConcept;
use App\Filament\Resources\TransactionConceptsResource\Pages;

class TransactionConceptsResource extends BaseTransactionConcept
{


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
