<?php

namespace App\Filament\Pages;

use App\Constants\OfferingConcept;
use App\Models\TransactionConcepts;
use App\Models\Transactions;
use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Tablero';
    use HasFiltersAction;


    protected function getHeaderActions(): array
    {
        return [
            $this->createTransactionAction(),
            $this->transactionFilterAction()
        ];
    }

    private function transactionFilterAction(): FilterAction
    {
        return FilterAction::make()
            ->form([
                DatePicker::make('startDate')
                    ->label('Fecha de Inicio')
                    ->required()
                    ->native(false),
                DatePicker::make('endDate')
                    ->label('Fecha de Fin')
                    ->required()
                    ->native(false),
            ]);
    }

    private function createTransactionAction(): CreateAction
    {
        return CreateAction::make()
        ->model(Transactions::class)
        ->modalHeading("Crear Registro")
        ->modalSubmitActionLabel("Registrar")
        ->label("Registrar Ofrenda")
        ->form([
            Grid::make(3)
                ->schema([
                    TextInput::make('amount')
                        ->label('Monto')
                        ->numeric()
                        ->required()
                        ->columnSpan(1), // Primera columna
                    DatePicker::make('transaction_date')
                        ->label('Fecha del Movimiento')
                        ->native(false)
                        ->required()
                        ->columnSpan(1),
                    Radio::make('concept_id')
                        ->label('Concepto')
                        ->required()
                        ->options(function () {
                            return TransactionConcepts::whereIn('name', [
                                OfferingConcept::OFRENDA_MARTES,
                                OfferingConcept::OFRENDA_JUEVES,
                                OfferingConcept::OFRENDA_SABADO,
                                OfferingConcept::OFRENDA_DOMINGO,
                            ])
                                ->pluck('name', 'id');
                        })
                        ->columnSpan(1)
                ]),



        ])->mutateFormDataUsing(function (array $data): array {
            $data['church_id'] = Auth::user()->church_id;
            $data['user_id'] = Auth::user()->id;

            return $data;
        });
    }
}
