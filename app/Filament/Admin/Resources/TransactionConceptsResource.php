<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TransactionConceptsResource\Pages;
use App\Filament\Base\BaseTransactionConcept;
use App\Filament\Components\TransactionConcept\AdminTransactionConcept;
use Illuminate\Database\Eloquent\Builder;


class TransactionConceptsResource extends BaseTransactionConcept
{   

    protected static ?string $navigationLabel = 'Conceptos Globales';
    protected static $formComponent = AdminTransactionConcept::class;

    public static function getEloquentQuery(): Builder
    {
        return static::$model::query()
        ->where('is_global', true );
    }

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
