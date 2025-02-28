<?php

namespace App\Filament\Base;

use App\Filament\Components\Church\FormChurch;
use App\Filament\Components\Church\SearchChurch;
use App\Filament\Components\Church\TableChurch;
use App\Models\Church;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


abstract class BaseChurch extends Resource
{

    protected static ?string $model = Church::class;
    protected static ?string $navigationLabel = 'Iglesias';
    protected static ?string $modelLabel = "Iglesia";
    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationGroup = 'Gestión del Sistema';


    public static function getGloballySearchableAttributes(): array
    {
        return SearchChurch::searchableAttributes();
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return SearchChurch::searchResultDetails($record);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function form(Form $form): Form
    {
        return FormChurch::make($form);
    }

    public static function table(Table $table): Table
    {
        return TableChurch::make($table);
    }

}