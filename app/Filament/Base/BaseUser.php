<?php


namespace App\Filament\Base;

use App\Filament\Components\User\FormUser;
use App\Filament\Components\User\SearchUser;
use App\Filament\Components\User\TableUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

abstract class BaseUser extends BaseResource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationLabel = 'Feligreses';
    protected static ?string $modelLabel = "Feligrés";
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Gestión del Sistema';
    protected static ?string $pluralModelLabel = 'Feligreses';

    protected static  $tableComponent = TableUser::class;
    protected static  $formComponent = FormUser::class;
    protected static  $searchComponent = SearchUser::class;


    public static function getEloquentQuery(): Builder
    {
        return static::$model::query()
            ->where('id', '!=', 1)
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
