<?php

namespace App\Enums;

enum OrderEditTypeEnum:string
{
    case KEY = 'edit-with';
    case WITH_OUT_MEAL = 'out-meal-system';
    case WITH_MEAL = 'meal-system';
}
