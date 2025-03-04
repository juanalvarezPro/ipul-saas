@php
    use App\Models\Church;

    // Cargar la iglesia solo una vez
    $church = Church::find(Auth::user()->church_id);

    // Obtener el resumen de la iglesia
    $churchSummary = $church->getSummary();
    $saldo = $churchSummary->saldo;
    $color = $saldo < 0 ? 'danger' : 'success';
    $formattedSaldo = number_format($saldo, 2) . ' PAB';

    // Obtener el nombre de la iglesia
    $churchName = $church->name ?? 'Sin Iglesia';
    $colorName = $churchName ? 'info' : 'gray';
@endphp

<!-- Mostrar el saldo -->
<x-filament::badge :color="$color">
    <span>{{$formattedSaldo}}</span>
</x-filament::badge>

<!-- Mostrar el nombre de la iglesia -->
<x-filament::badge :color="$colorName" class="hidden sm:block">
    <span>{{ $churchName }}</span>
</x-filament::badge>
