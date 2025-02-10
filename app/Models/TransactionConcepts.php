<?php

namespace App\Models;

use App\Enums\transactionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionConcepts extends Model
{
    protected $fillable  = ['name', 'description' ,'active', 'transaction_type'];

    protected $casts = [
        'transaction_type' => transactionStatus::class
    ];
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'concept_id');
    }
}
