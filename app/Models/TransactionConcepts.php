<?php

namespace App\Models;

use App\Enums\transactionStatus;
use App\Models\Scopes\TransactionConceptScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TransactionConcepts extends Model
{
    use SoftDeletes;

    protected $fillable  = ['name', 'description', 'active', 'transaction_type', 'church_id', 'user_id', 'is_global', 'parent_id'];

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
            set: fn(string $value) => Str::ascii(Str::lower(preg_replace('/\s+/', ' ', $value))),
        );
    }


    /**
     * Relación con el concepto padre.
     */
    public function parent()
    {
        return $this->belongsTo(TransactionConcepts::class, 'parent_id');
    }

    /**
     * Relación con los conceptos hijos.
     */
    public function children()
    {
        return $this->hasMany(TransactionConcepts::class, 'parent_id');
    }

    public function childrenWithAmount()
    {
        return $this->children()
            ->withSum(['transactions as total_amount' => function ($query) {
                $query->whereMonth('transaction_date', now()->month);
            }], 'amount');
    }
}
