<?php

namespace App\Filament\Base;

use App\Models\TransactionConcepts;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Filament\Components\TransactionConcept\FormTransactionConcept;
use App\Filament\Components\TransactionConcept\SearchTransactionConcept;
use App\Filament\Components\TransactionConcept\TableTransactionConcept;
use Filament\Forms\Form;
use Filament\Tables\Table;

abstract class BaseTransactionConcept extends Resource
{
    protected static ?string $model = TransactionConcepts::class;
    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';
    protected static ?string $navigationLabel = 'Conceptos';
    protected static ?string $navigationGroup = 'Gestión del Sistema';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = "Concepto";
    protected static ?string $navigationBadgeTooltip = 'El numero de Conceptos';


    public static function getGloballySearchableAttributes(): array
    {
        return SearchTransactionConcept::searchableAttributes();
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return SearchTransactionConcept::searchResultDetails($record);
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('church_id', Auth::user()->church_id);
    }


    public static function form(Form $form): Form
    {
        return FormTransactionConcept::make($form, Self::$model);
    }

    public static function table(Table $table): Table
    {
        return TableTransactionConcept::make($table);
    }
}
