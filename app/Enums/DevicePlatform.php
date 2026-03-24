<?php


namespace App\Enums;

enum DevicePlatform: string
{
    case IOS = "ios";
    case ANDROID = "android";
    case WEB = "web";

    public static function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
