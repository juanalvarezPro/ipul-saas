<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum userStatus: string implements HasLabel, HasColor, HasIcon
{
    case PENDING = 'pending';         // Usuario registrado pero no verificado/aprobado
    case APPROVED = 'approved';       // Usuario activo y aprobado
    case SUSPENDED = 'suspended';     // Usuario bloqueado temporalmente
  
    public function getLabel(): ?string
    {
        return match ($this){
            self::PENDING=>'pendiente',
            self::APPROVED=> 'aprobado',
            self::SUSPENDED => 'suspendido',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::APPROVED => 'success',
            self::PENDING => 'warning',
            self::SUSPENDED => 'gray'
        };
    }

    public function getIcon(): ?string
    {
        return match ($this){
            self::APPROVED => 'heroicon-o-check-circle', 
            self::PENDING => 'heroicon-o-exclamation-circle',  
            self::SUSPENDED => 'heroicon-o-lock-closed' 
        };
    }
}
