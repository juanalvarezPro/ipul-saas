<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $fillable = ['amount', 'description','concept_id', 'transaction_type_id', 'transaction_date'];

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function transactionConcept()
    {
        return $this->belongsTo(TransactionConcepts::class, 'concept_id');  // 'concept_id' es la clave foránea en 'transactions'
    }

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id');  // 'concept_id' es la clave foránea en 'transactions'
    }
}
