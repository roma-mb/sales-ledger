<?php

namespace App\Enumerations;

abstract class Commission
{
    public const PERCENTAGE = 0.085;

    public static function applyPercentage(float $value): float
    {
        return round(($value * self::PERCENTAGE), 2);
    }
}
