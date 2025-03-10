<?php

namespace App\Filament\Components\TransactionConcept;

use Filament\Forms\Form;


class AppTransactionConcept
{
    public static function make(Form $form): Form
    {
        return $form
            ->schema([
                FormTransactionConcept::nameField(),
                FormTransactionConcept::parentSelect(),
                FormTransactionConcept::transactionTypeSelect(),
                FormTransactionConcept::descriptionField()
            ])
            ->columns(4);
    }
}
