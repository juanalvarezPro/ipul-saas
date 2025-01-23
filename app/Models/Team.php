<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    protected $guarded = [];
    
    public function transactions(): hasMany
    {
        return $this->hasMany(Transactions::class);
    }

    public function transactionConcepts(): hasMany
    {
        return $this->hasMany(TransactionConcepts::class);
    }

    public function TransactionTypes(): hasMany
    {
        return $this->hasMany(TransactionType::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }


}
