<?php

namespace App;

enum MealSystemType: string
{
    case NORMAL =  "normal";
    case RAMADAN = 'ramadan';

    public static function toArray(){
        return array_column(self::cases(), 'value');
    }
}
