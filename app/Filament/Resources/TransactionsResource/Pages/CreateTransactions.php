<?php

namespace App\Filament\Resources\TransactionsResource\Pages;

use App\Filament\Resources\TransactionsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTransactions extends CreateRecord
{
    protected static string $resource = TransactionsResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array {

        $data['church_id'] = Auth::user()->church_id;
        $data['user_id'] = Auth::user()->id;
        return $data;
    }
    
}
