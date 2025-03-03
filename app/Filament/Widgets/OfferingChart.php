<?php

namespace App\Filament\Widgets;

use App\Constants\OfferingConcept;
use Filament\Widgets\ChartWidget;
use App\Models\Transactions;
use App\Models\TransactionConcepts;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class OfferingChart extends ChartWidget
{
    use HasWidgetShield;
    
    protected static ?string $heading = 'Comportamiento de Ofrendas';

    protected function getData(): array
    { 
        $concepts = $this->getOfferingConcepts();
        $churchId = Auth::user()->church_id;

        if ($concepts->isEmpty()) {
            return ['datasets' => [], 'labels' => []];
        }

        $labels = $this->getMonthLabels();
        $datasets = $this->generateDatasets($concepts, $churchId);

        return ['datasets' => $datasets, 'labels' => $labels];
    }

    protected function getOfferingConcepts()
    {
        return cache()->remember('offering_concepts', now()->addHours(6), function () {
            return TransactionConcepts::whereIn('name', [
                OfferingConcept::OFRENDA_MARTES,
                OfferingConcept::OFRENDA_JUEVES,
                OfferingConcept::OFRENDA_SABADO,
                OfferingConcept::OFRENDA_DOMINGO
            ])->get();
        });
    }

    protected function getMonthLabels(): array
    {
        return collect(range(1, 12))
            ->map(fn($month) => ucfirst(Carbon::create()->month($month)->locale('es')->shortMonthName))
            ->toArray();
    }

    protected function generateDatasets($concepts, $churchId): array
    {
        $datasets = [];
        $transactions = $this->getTransactionsByConcepts($concepts, $churchId);

        foreach ($concepts as $concept) {
            $monthlyData = array_fill(0, 12, 0);

            foreach ($transactions as $transaction) {
                if ($transaction->concept_id === $concept->id) {
                    $monthlyData[$transaction->month - 1] = $transaction->total;
                }
            }
            
            $datasets[] = [
                'label' => $concept->name,
                'data' => $monthlyData,
                'borderColor' => $this->getColorForConcept($concept->name),
                'backgroundColor' => $this->getColorForConcept($concept->name, 0.2),
                'fill' => true,
                'tension' => 0.4,
            ];
        }
        
        return $datasets;
    }

    protected function getTransactionsByConcepts($concepts, $churchId)
    {
        return Transactions::whereIn('concept_id', $concepts->pluck('id'))
            ->where('church_id', $churchId)
            ->whereYear('transaction_date', Carbon::now()->year)
            ->whereNull('deleted_at')
            ->selectRaw('concept_id, EXTRACT(MONTH FROM transaction_date) as month, SUM(amount) as total')
            ->groupBy('concept_id', 'month')
            ->get();
    }

    protected function getColorForConcept(string $conceptName, float $opacity = 1): string
    {
      return OfferingConcept::getColor($conceptName, $opacity);
    }

    protected function getType(): string
    {
        return 'line';
    }
}
