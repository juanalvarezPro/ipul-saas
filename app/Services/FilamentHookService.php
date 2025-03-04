<?php

namespace App\Services;

use Filament\Support\Facades\FilamentView;
use Illuminate\View\View;

class FilamentHookService
{
    public static function register(): void
    {

        FilamentView::registerRenderHook(
            'panels::global-search.before',
            fn(): View => view('church-badges'),
        );
    }
}
