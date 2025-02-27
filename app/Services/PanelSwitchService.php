<?php
namespace App\Services;

use BezhanSalleh\PanelSwitch\PanelSwitch;

class PanelSwitchService
{
    public static function configure(): void
    {
        PanelSwitch::configureUsing(function (PanelSwitch $panelSwitch) {
            $panelSwitch
                ->panels(['admin', 'app'])
                ->modalWidth('sm')
                ->slideOver()
                ->modalHeading('Paneles Disponibles')
                ->visible(fn (): bool => auth()->user()?->hasAnyRole(['super_admin']))
                ->icons([
                    'admin' => 'heroicon-o-square-2-stack',
                    'app' => 'heroicon-o-star',
                ])
                ->iconSize(16)
                ->labels([
                    'admin' => 'Administrador',
                    'app' => 'Personal'
                ]);
        });
    }
}
