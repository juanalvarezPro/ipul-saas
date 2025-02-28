<?php

namespace App\Filament\Resources;

use App\Filament\Base\BaseChurch;
use App\Filament\Resources\ChurchResource\Pages;



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
