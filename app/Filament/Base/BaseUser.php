<?php


namespace App\Filament\Base;

use App\Filament\Components\User\FormUser;
use App\Filament\Components\User\SearchUser;
use App\Filament\Components\User\TableUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

abstract class BaseUser extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationLabel = 'Feligreses';
    protected static ?string $modelLabel = "Feligrés";
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Gestión del Sistema';
    protected static ?string $pluralModelLabel = 'Feligreses';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return SearchUser::searchableAttributes();
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return SearchUser::searchResultDetails($record);
    }

    public static function form(Form $form): Form
    {
        return FormUser::make($form, Self::$model);
    }

    public static function table(Table $table): Table
    {
        return TableUser::make($table);
    }
}
