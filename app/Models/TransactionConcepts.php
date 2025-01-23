<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionConcepts extends Model
{
    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'concept_id');
    }
}
