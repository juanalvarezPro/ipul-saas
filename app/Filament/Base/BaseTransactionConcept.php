<?php

namespace App\Filament\Base;

use App\Models\TransactionConcepts;
use App\Filament\Components\TransactionConcept\FormTransactionConcept;
use App\Filament\Components\TransactionConcept\SearchTransactionConcept;
use App\Filament\Components\TransactionConcept\TableTransactionConcept;

abstract class BaseTransactionConcept extends BaseResource
{
    protected static ?string $model = TransactionConcepts::class;
    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';
    protected static ?string $navigationLabel = 'Conceptos';
    protected static ?string $navigationGroup = 'Gestión del Sistema';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = "Concepto";

    protected static $formComponent = FormTransactionConcept::class;
    protected static $tableComponent = TableTransactionConcept::class;
    protected static $searchComponent = SearchTransactionConcept::class;
   
}
