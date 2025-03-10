<?php

namespace App\Filament\Widgets;

use App\Models\Church;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Concerns\InteractsWithPageFilters;


class AppStatsOverview extends BaseWidget
{
    use HasWidgetShield, InteractsWithPageFilters;

    protected ?string $heading = 'Movimientos';

    protected function getStats(): array
    {
        $church = Church::find(Auth::user()->church_id);
        if (!$church) {
            return [];
        }

        $churchSummary = $church->getSummary() ?? (object) ['total_income' => 0, 'total_expense' => 0, 'saldo' => 0];


        return [
            Stat::make('Total Ingresos', number_format($churchSummary->total_income ?? 0, 2) . ' PAB')
                ->description('Suma total de ingresos')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success')
                ->extraAttributes([
                    'class' => 'hidden md:block',
                ]),

            Stat::make('Total Egresos', number_format($churchSummary->total_expense ?? 0, 2) . ' PAB')
                ->description('Suma total de egresos')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('danger')
                ->extraAttributes([
                    'class' => 'hidden md:block',
                ]),

            Stat::make('Saldo Disponible', number_format($churchSummary->saldo ?? 0, 2) . ' PAB')
                ->description('Diferencia entre ingresos y egresos')
                ->descriptionIcon($churchSummary->saldo >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($churchSummary->saldo >= 0 ? 'success' : 'danger'),
        ];
    }
}
