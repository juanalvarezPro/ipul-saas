<?php

namespace App\Filament\Resources;

use App\Filament\Base\BaseTransaction;
use App\Filament\Resources\TransactionsResource\Pages;


class TransactionsResource extends BaseTransaction
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransactions::route('/create'),
            'edit' => Pages\EditTransactions::route('/{record}/edit'),
        ];
    }
}
