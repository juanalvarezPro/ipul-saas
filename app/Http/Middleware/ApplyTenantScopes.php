<?php

namespace App\Http\Middleware;

use App\Models\TransactionConcepts;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\Builder;

class ApplyTenantScopes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        TransactionConcepts::addGlobalScope(
            fn (Builder $query) => $query->whereBelongsTo(Filament::getTenant())
        );
        return $next($request);
    }
}
