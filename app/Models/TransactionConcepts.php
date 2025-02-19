<?php

namespace App\Models;

use App\Enums\transactionStatus;
use App\Models\Scopes\TransactionConceptScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionConcepts extends Model
{
    use SoftDeletes;

    protected $fillable  = ['name', 'description', 'active', 'transaction_type', 'church_id', 'user_id', 'is_global'];

    protected $casts = [
        'transaction_type' => transactionStatus::class
    ];
    // Aplica el scope globalmente a este modelo
    protected static function booted()
    {
        static::addGlobalScope(new TransactionConceptScope);
    }
    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'concept_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => strtolower($value),
        );
    }
}
