<?php

namespace App\Enums;

enum Label: string
{
    case CLASSIC = 'classic';
    case GOLD = 'gold';
    case LEGEND = 'legend';

    public function name(): string
    {
        return match ($this) {
            self::CLASSIC => 'Blood League Label',
            self::GOLD => 'Blood League Label Gold',
            self::LEGEND => 'Blood League Label Legend',
        };
    }
}
