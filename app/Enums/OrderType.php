<?php

namespace App\Enums;

enum OrderType: string
{
    case NORMAL =  "normal";
    case RAMADAN = 'ramadan';
    case BOTH = 'both';

    public static function toArray(){
        return array_column(self::cases(), 'value');
    }
}
