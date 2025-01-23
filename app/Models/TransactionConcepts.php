<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionConcepts extends Model
{
    protected $fillable  = ['name', 'description' ,'active'];
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'concept_id');
    }
}
