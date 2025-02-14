<?php

namespace App\Models;

use App\Enums\transactionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionConcepts extends Model
{
    use SoftDeletes;

    protected $fillable  = ['name', 'description', 'active', 'transaction_type', 'church_id', 'user_id'];

    protected $casts = [
        'transaction_type' => transactionStatus::class
    ];

    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'concept_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
