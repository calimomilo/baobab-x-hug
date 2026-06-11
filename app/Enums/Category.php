<?php

namespace App\Enums;

enum Category: string
{
    case THE_CLIMBER = 'The Climber';
    case THE_FLOOD = 'The Flood';
    case THE_PULSE = 'The Pulse';
    case THE_NEW_VEIN = 'The New Vein';
    case THE_GOLDEN_HEART = 'The Golden Heart';

    /**
     * Retourne le label (nom complet en français) de chaque médaille
     */
    public function label(): string
    {
        return match ($this) {
            self::THE_CLIMBER => 'Médaille de la meilleure progression',
            self::THE_FLOOD => 'Médaille de la meilleure participation',
            self::THE_PULSE => 'Médaille du meilleur soutien',
            self::THE_NEW_VEIN => 'Médaille de la meilleure nouvelle entreprise',
            self::THE_GOLDEN_HEART => 'Prix du jury',
        };
    }

    /**
     * Retourne le slug de chaque médaille
     */
    public function slug(): string
    {
        return match ($this) {
            self::THE_CLIMBER => 'climber',
            self::THE_FLOOD => 'flood',
            self::THE_PULSE => 'pulse',
            self::THE_NEW_VEIN => 'new_vein',
            self::THE_GOLDEN_HEART => 'golden_heart',
        };
    }
}
