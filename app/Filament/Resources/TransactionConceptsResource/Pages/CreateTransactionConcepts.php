<?php

namespace App\Filament\Resources\TransactionConceptsResource\Pages;

use App\Filament\Resources\TransactionConceptsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTransactionConcepts extends CreateRecord
{
    protected static string $resource = TransactionConceptsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array {

        $data['church_id'] = Auth::user()->church_id;
        $data['user_id'] = Auth::user()->id;
        return $data;
    }
}
