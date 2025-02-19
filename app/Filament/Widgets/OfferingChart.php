<?php

namespace App\Filament\Widgets;

use App\Enums\OfferingConcept;
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
        return TransactionConcepts::whereIn('name', array_column(OfferingConcept::cases(), 'value'))->get();
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

        foreach ($concepts as $concept) {
            $transactions = $this->getTransactionsByConcept($concept, $churchId);
            $monthlyData = $this->calculateMonthlyTotals($transactions);

            $datasets[] = [
                'label' => $concept->name,
                'data' => $monthlyData,
                'borderColor' => $this->getColorForConcept($concept),
                'backgroundColor' => $this->getColorForConcept($concept, 0.2),
                'fill' => true,
                'tension' => 0.4,
            ];
        }

        return $datasets;
    }

    protected function getTransactionsByConcept($concept, $churchId)
    {
        return Transactions::where('concept_id', $concept->id)
            ->where('church_id', $churchId)
            ->whereYear('transaction_date', Carbon::now()->year)
            ->get();
    }

    protected function calculateMonthlyTotals($transactions): array
    {
        $monthlyData = array_fill(0, 12, 0);
        foreach ($transactions as $transaction) {
            $month = Carbon::parse($transaction->transaction_date)->month - 1;
            $monthlyData[$month] += $transaction->amount;
        }
        return $monthlyData;
    }
    protected function getColorForConcept(TransactionConcepts $concept, float $opacity = 1): string
    {
        $colors = OfferingConcept::color();

        // Verifica si el concepto está en el enum OfferingConcept
        $conceptEnum = OfferingConcept::tryFrom($concept->name);

        $color = $colors[$conceptEnum->value] ?? 'rgb(0, 0, 0)';

        return $opacity === 1 ? $color : str_replace(')', ", {$opacity})", $color . ')');
    }

    protected function getType(): string
    {
        return 'line';
    }
}
