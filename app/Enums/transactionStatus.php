<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum transactionStatus: string implements HasLabel, HasColor, HasIcon
{
    case INCOME = 'income';         // Ingresos
    case EXPENSE = 'expense';       //Egresos
  
    public function getLabel(): ?string
    {
        return match ($this){
            self::INCOME=>'Ingreso',
            self::EXPENSE=> 'Egreso',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::INCOME => 'success',
            self::EXPENSE => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this){
            self::INCOME => 'heroicon-o-arrow-trending-up', 
            self::EXPENSE => 'heroicon-o-arrow-trending-down',  
        };
    }
}
