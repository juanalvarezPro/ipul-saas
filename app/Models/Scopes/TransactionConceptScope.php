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
            $query->where('church_id', Auth::user()->church_id)  // Filtrar por la iglesia
                  ->orWhere('is_global', true);   // Incluir conceptos globales
        });
    }
}
