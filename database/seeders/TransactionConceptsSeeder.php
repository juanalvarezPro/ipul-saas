<?php

namespace Database\Seeders;

use App\Constants\OfferingConcept;
use App\Enums\transactionStatus;
use App\Models\TransactionConcepts;
use Illuminate\Database\Seeder;

class TransactionConceptsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insertar los conceptos de ofrenda
        $concepts = [
            OfferingConcept::OFRENDA_MARTES,
            OfferingConcept::OFRENDA_JUEVES,
            OfferingConcept::OFRENDA_SABADO,
            OfferingConcept::OFRENDA_DOMINGO,
        ];

        foreach ($concepts as $concept) {
            TransactionConcepts::updateOrCreate(
                ['name' => $concept],
                [
                    'description' => 'Concepto de ' . ucfirst(str_replace('ofrenda ', '', $concept)),
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
