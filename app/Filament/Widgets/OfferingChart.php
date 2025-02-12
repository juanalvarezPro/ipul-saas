<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Transactions;
use App\Models\TransactionConcepts;
use Carbon\Carbon;
use Filament\Facades\Filament;

class OfferingChart extends ChartWidget
{
    protected static ?string $heading = 'Comportamiento de Ofrendas';

    protected function getData(): array
    { 
        $concepts = $this->getOfferingConcepts();
        if ($concepts->isEmpty() || !$tenant = Filament::getTenant()) {
            return ['datasets' => [], 'labels' => []];
        }

        $labels = $this->getMonthLabels();
        $datasets = $this->generateDatasets($concepts, $tenant);

        return ['datasets' => $datasets, 'labels' => $labels];
    }

    protected function getOfferingConcepts()
    {
        return TransactionConcepts::whereIn('name', [
            'Ofrenda Martes',
            'Ofrenda Jueves',
            'Ofrenda Sábado',
            'Ofrenda Dominical'
        ])->get();
    }

    protected function getMonthLabels(): array
    {
        return ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
    }

    protected function generateDatasets($concepts, $tenant): array
    {
        $datasets = [];

        foreach ($concepts as $concept) {
            $transactions = $this->getTransactionsByConcept($concept, $tenant);
            $monthlyData = $this->calculateMonthlyTotals($transactions);
            
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

    protected function getTransactionsByConcept($concept, $tenant)
    {
        return Transactions::where('concept_id', $concept->id)
            ->where('workspace_id', $tenant->id)
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

    protected function getColorForConcept(string $conceptName, float $opacity = 1): string
    {
        $colors = [
            'Ofrenda Martes' => 'rgb(75, 192, 192)',
            'Ofrenda Jueves' => 'rgb(255, 159, 64)',
            'Ofrenda Sábado' => 'rgb(17, 100, 236)',
            'Ofrenda Dominical' => 'rgb(255, 99, 132)',
        ];

        $color = $colors[$conceptName] ?? 'rgb(0, 0, 0)';
        return $opacity === 1 ? $color : str_replace(')', ", {$opacity})", $color . ')');
    }

    protected function getType(): string
    {
        return 'line';
    }
}
