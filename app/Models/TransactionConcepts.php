<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionConcepts extends Model
{
    protected $fillable  = ['name', 'description' ,'active', 'transaction_type_id'];
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'concept_id');
    }

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type_id');
    }
}
