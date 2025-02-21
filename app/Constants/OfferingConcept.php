<?php

namespace App\Constants;

class OfferingConcept
{
    public const OFRENDA_MARTES = 'ofrenda martes';
    public const OFRENDA_JUEVES = 'ofrenda jueves';
    public const OFRENDA_SABADO = 'ofrenda sábado';
    public const OFRENDA_DOMINGO = 'ofrenda domingo';

    // Método para obtener el color asociado a cada concepto
    public static function getColor(string $conceptName, float $opacity = 1): string
    {
        $colors = [
            self::OFRENDA_MARTES => 'rgb(75, 192, 192)',
            self::OFRENDA_JUEVES => 'rgb(255, 159, 64)',
            self::OFRENDA_SABADO => 'rgb(17, 100, 236)',
            self::OFRENDA_DOMINGO => 'rgb(255, 99, 132)',
        ];

        $color = $colors[$conceptName] ?? 'rgb(0, 0, 0)';

        // Si hay opacidad, la aplicamos
        return $opacity === 1 ? $color : str_replace(')', ", {$opacity})", $color . ')');
    }
}
