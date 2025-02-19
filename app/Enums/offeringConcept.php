<?php

namespace App\Enums;

enum OfferingConcept: string
{
    case OFRENDA_MARTES = 'ofrenda martes';
    case OFRENDA_JUEVES = 'ofrenda jueves';
    case OFRENDA_SABADO = 'ofrenda sábado';
    case OFRENDA_DOMINGO = 'ofrenda domingo';

    // Método para obtener el color asociado a cada concepto
    public static function color(): array
    {
        return[
            self::OFRENDA_MARTES->value => 'rgb(75, 192, 192)',
            self::OFRENDA_JUEVES->value => 'rgb(255, 159, 64)',
            self::OFRENDA_SABADO->value => 'rgb(17, 100, 236)',
            self::OFRENDA_DOMINGO->value => 'rgb(255, 99, 132)',
        ];
    }


    public static function options(): array
    {
        return [
            self::OFRENDA_MARTES->value => 'Ofrenda Martes',
            self::OFRENDA_JUEVES->value => 'Ofrenda Jueves',
            self::OFRENDA_SABADO->value => 'Ofrenda Sábado',
            self::OFRENDA_DOMINGO->value => 'Ofrenda Domingo',
        ];
    }
}
