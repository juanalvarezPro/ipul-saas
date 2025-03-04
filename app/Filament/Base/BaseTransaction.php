<?php

namespace App\Filament\Base;

use App\Filament\Components\Transaction\FormTransaction;
use App\Filament\Components\Transaction\SearchTransaction;
use App\Filament\Components\Transaction\TableTransaction;
use App\Models\Transactions;


abstract class BaseTransaction extends BaseResource
{

    protected static ?string $model = Transactions::class;
    protected static ?string $navigationLabel = 'Movimientos';
    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';
    protected static ?string $modelLabel = 'Movimiento';
    
    protected static $tableComponent = TableTransaction::class;
    protected static $formComponent = FormTransaction::class;
    protected static $searchComponent = SearchTransaction::class;
}
