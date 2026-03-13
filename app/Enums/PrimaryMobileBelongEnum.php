<?php

namespace App\Enums;

enum PrimaryMobileBelongEnum: string
{
    case Self = "1";
    case Spouse = "2";
    case Parent = "20";
    case Son = "5";
    case Daughter = "6";
    case Brother = "7";
    case Sister = "8";
    case Relative = "21";
    case Friend = "22";

    public static function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
