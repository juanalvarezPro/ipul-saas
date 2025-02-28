<?php

namespace App\Filament\Resources;

use App\Filament\Base\BaseUser;
use App\Filament\Resources\UserResource\Pages;


class UserResource extends BaseUser
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
