<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;
    protected $fillable = ['amount', 'description', 'team_id'];

    public function team(){
        return $this->belongsTo(Team::class);
    }
}
