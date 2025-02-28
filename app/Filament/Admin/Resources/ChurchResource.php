<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ChurchResource\Pages;
use App\Filament\Base\BaseChurch;

class ChurchResource extends BaseChurch
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
            'index' => Pages\ListChurches::route('/'),
            'create' => Pages\CreateChurch::route('/create'),
            'edit' => Pages\EditChurch::route('/{record}/edit'),
        ];
    }


}
