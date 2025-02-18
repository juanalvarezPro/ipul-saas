<?php

namespace App\Filament\Admin\Resources\TransactionConceptsResource\Pages;

use App\Filament\Admin\Resources\TransactionConceptsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransactionConcepts extends EditRecord
{
    protected static string $resource = TransactionConceptsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
