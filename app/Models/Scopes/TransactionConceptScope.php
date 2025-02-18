<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class TransactionConceptScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where(function($query) {
            $query->where('user_id', Auth::id())  // El concepto asociado al usuario logueado
                  ->orWhere('is_global', true);   // O los conceptos globales
        });
    }
}
