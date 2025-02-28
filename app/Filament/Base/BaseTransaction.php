<?php

namespace App\Filament\Base;

use App\Filament\Components\Transaction\FormTransaction;
use App\Filament\Components\Transaction\SearchTransaction;
use App\Filament\Components\Transaction\TableTransaction;
use App\Models\Transactions;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

abstract class BaseTransaction extends Resource
{

    protected static ?string $model = Transactions::class;
    protected static ?string $navigationLabel = 'Movimientos';
    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';
    protected static ?string $modelLabel = 'Movimiento';
    protected static ?string $navigationBadgeTooltip = 'El numero de Movimientos';
    protected static int $globalSearchResultsLimit = 20;

    public static function getGloballySearchableAttributes(): array
    {
        return SearchTransaction::searchableAttributes();
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return SearchTransaction::searchResultDetails($record);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('church_id', Auth::user()->church_id);
    }

    public static function form(Form $form): Form
    {
        return FormTransaction::make($form);
    }

    public static function table(Table $table): Table
    {
        return TableTransaction::make($table);
    }

}