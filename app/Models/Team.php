<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = [];
    
    public function transactions()
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

    public function members()
    {
        return $this->belongsToMany(User::class);
    }


}
