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
        $activeFilter = $this->filter;
        // Obtener los conceptos de las ofrendas
        $concepts = TransactionConcepts::whereIn('name', [
            'Ofrenda Martes',
            'Ofrenda Jueves',
            'Ofrenda Sábado',
            'Ofrenda Dominical'
        ])->get();

        if ($concepts->isEmpty()) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        // Obtener el tenant actual
        $tenant = Filament::getTenant();

        if (!$tenant) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        // Inicializar los datos para el gráfico
        $monthlyData = array_fill(0, 12, 0);  // Crear un array con 12 valores (para cada mes)
        $labels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        $datasets = [];

        // Generar un conjunto de datos para cada concepto
        foreach ($concepts as $concept) {
            // Filtrar las transacciones por concepto, tenant y año actual
            $transactions = Transactions::where('concept_id', $concept->id)
                ->where('workspace_id', $tenant->id)  // Filtrar por el tenant actual
                ->whereYear('transaction_date', Carbon::now()->year)  // Filtrar por el año actual
                ->get();

            $monthlyData = array_fill(0, 12, 0);  // Reiniciar los datos mensuales para este concepto

            // Sumar las transacciones por mes para este concepto
            foreach ($transactions as $transaction) {
                $month = Carbon::parse($transaction->transaction_date)->month - 1;  // Mes (0-11)
                $monthlyData[$month] += $transaction->amount;
            }

            // Agregar los datos al conjunto de datos
            $datasets[] = [
                'label' => $concept->name,
                'data' => $monthlyData,
                'borderColor' => $this->getColorForConcept($concept->name),  // Color dinámico por concepto
                'backgroundColor' => $this->getColorForConcept($concept->name, 0.2),  // Color de fondo suave
                'fill' => true,
                'tension' => 0.4,
            ];
        }

        // Devolver los datos para el gráfico
        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    /**
     * Método para asignar colores dinámicos a los conceptos
     */
    protected function getColorForConcept(string $conceptName, float $opacity = 1): string
    {
        $colors = [
            'Ofrenda Martes' => 'rgb(75, 192, 192)',  // Verde claro
            'Ofrenda Jueves' => 'rgb(255, 159, 64)',  // Naranja
            'Ofrenda Sábado' => 'rgb(17, 100, 236)', // Azul
            'Ofrenda Dominical' => 'rgb(255, 99, 132)', // Rojo
        ];

        $color = $colors[$conceptName] ?? 'rgb(0, 0, 0)';  // Color predeterminado en caso de no encontrar el concepto

        // Si se especifica una opacidad, se agrega a la cadena de color
        return $opacity === 1 ? $color : str_replace(')', ", {$opacity})", $color . ')');
    }

    protected function getType(): string
    {
        return 'line';  // Tipo de gráfico (línea)
    }
}
