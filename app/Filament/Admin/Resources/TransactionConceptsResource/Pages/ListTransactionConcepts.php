<?php

namespace App\Filament\Admin\Resources\TransactionConceptsResource\Pages;

use App\Filament\Admin\Resources\TransactionConceptsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactionConcepts extends ListRecords
{
    protected static string $resource = TransactionConceptsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
