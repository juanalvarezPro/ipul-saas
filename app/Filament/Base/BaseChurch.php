<?php

namespace App\Filament\Base;

use App\Filament\Components\Church\FormChurch;
use App\Filament\Components\Church\SearchChurch;
use App\Filament\Components\Church\TableChurch;
use App\Models\Church;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


abstract class BaseChurch extends BaseResource
{

    protected static ?string $model = Church::class;
    protected static ?string $navigationLabel = 'Iglesias';
    protected static ?string $modelLabel = "Iglesia";
    protected static ?string $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationGroup = 'Gestión del Sistema';
    
    protected static $formComponent = FormChurch::class;
    protected static $tableComponent = TableChurch::class;
    protected static $searchComponent = SearchChurch::class;

    public static function getEloquentQuery(): Builder
    {
        return static::$model::query()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}