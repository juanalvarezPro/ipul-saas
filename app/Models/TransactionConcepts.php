<?php

namespace App\Models;

use App\Enums\transactionStatus;
use Illuminate\Database\Eloquent\Model;

class TransactionConcepts extends Model
{
    protected $fillable  = ['name', 'description' ,'active', 'transaction_type'];

    protected $casts = [
        'transaction_type' => transactionStatus::class
    ];

    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'concept_id');
    }

    public function user () {
        return $this->belongsTo(User::class, 'user_id');
    }
}
