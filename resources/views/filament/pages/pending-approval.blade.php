@php
    use Filament\Support\Facades\FilamentView;
    use Filament\View\PanelsRenderHook;
@endphp

<x-filament-panels::page.simple>
    {{ FilamentView::renderHook(PanelsRenderHook::AUTH_REGISTER_FORM_BEFORE) }}

    <x-filament-panels::form id="form" wire:submit="register">
        <p class="text-center">
            {{ __('Tu cuenta aún está en proceso de aprobación. ¡Los administradores se comunicarán contigo pronto!') }}
        </p>

        <x-filament::button color="info"  wire:click="logout">
            ¡Espero tu aprobación!
        </x-filament::button>
    </x-filament-panels::form>

    {{ FilamentView::renderHook(PanelsRenderHook::AUTH_REGISTER_FORM_AFTER) }}
</x-filament-panels::page.simple>
