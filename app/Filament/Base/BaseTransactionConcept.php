<?php

namespace App\Filament\Base;

use App\Filament\Components\TransactionConcept\AppTransactionConcept;
use App\Models\TransactionConcepts;
use App\Filament\Components\TransactionConcept\SearchTransactionConcept;
use App\Filament\Components\TransactionConcept\TableTransactionConcept;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

abstract class BaseTransactionConcept extends BaseResource
{
    protected static ?string $model = TransactionConcepts::class;
    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';
    protected static ?string $navigationLabel = 'Conceptos';
    protected static ?string $navigationGroup = 'Gestión del Sistema';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = "Concepto";

    protected static $formComponent = AppTransactionConcept::class;
    protected static $tableComponent = TableTransactionConcept::class;
    protected static $searchComponent = SearchTransactionConcept::class;
   
    public static function getEloquentQuery(): Builder
    {
        return static::$model::query()
        ->where('church_id', Auth::user()->church_id)
        ->where('is_global', false )
        ->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }
}
