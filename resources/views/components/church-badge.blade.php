@php
    $user = Auth::user();
    $churchName = $user?->church?->name ?? 'Sin Iglesia';
    $color = $user?->church?->name ? 'info' : 'gray';
@endphp

<x-filament::badge :color="$color">
    <span>{{ $churchName }}</span>
</x-filament::badge>
