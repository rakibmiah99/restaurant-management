<?php

namespace App\Enums;

enum UserTypeEnum: string
{
    case SYSTEM =  "system";
    case NORMAL = 'normal';

    public static function toArray(){
        return array_column(self::cases(), 'value');
    }
}
