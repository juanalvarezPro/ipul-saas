<?php

namespace App\Filament\Base;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

abstract class BaseResource extends Resource
{
    protected static $formComponent;
    protected static $tableComponent;
    protected static $searchComponent;
    protected static int $globalSearchResultsLimit = 20;

    public static function getGloballySearchableAttributes(): array
    {
       return static::$searchComponent::searchableAttributes();
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return static::$searchComponent::searchResultDetails($record);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('church_id', Auth::user()->church_id)->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }
    public static function form(Form $form): Form
    {
        return static::$formComponent::make($form);
    }

    public static function table(Table $table): Table
    {
        return static::$tableComponent::make($table);
    }
}
