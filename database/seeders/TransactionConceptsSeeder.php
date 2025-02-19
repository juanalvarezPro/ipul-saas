<?php

namespace Database\Seeders;

use App\Enums\OfferingConcept;
use App\Enums\transactionStatus;
use App\Models\TransactionConcepts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionConceptsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Offerings = OfferingConcept::cases();
        foreach ($Offerings as $Offering) {
            TransactionConcepts::updateOrCreate(
                ['name' => $Offering->value],
                [
                    'description' => 'Concepto de ' . ucfirst($Offering->value),
                    'active' => true,
                    'is_global' => true,
                    'transaction_type' => transactionStatus::INCOME,
                    'user_id' => 1,
                    'church_id' => 1,
                ]
            );
        }
    }
}
