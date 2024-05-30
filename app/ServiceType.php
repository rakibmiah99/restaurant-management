<?php

namespace App;

enum ServiceType: string
{
    case STANDARD = 'standard';
    case VIP = 'vip';

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
