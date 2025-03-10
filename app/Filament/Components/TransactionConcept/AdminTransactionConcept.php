<?php

namespace App\Filament\Components\TransactionConcept;

use Filament\Forms\Form;


class AdminTransactionConcept
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                FormTransactionConcept::nameField(),
                FormTransactionConcept::transactionTypeSelect(),
                FormTransactionConcept::descriptionField(),
            ])
            ->columns(3);
    }
}
