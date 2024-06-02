<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HallMealTime extends Model
{
    use HasFactory;

    public function meal_system(){
        return $this->belongsTo(MealSystem::class, 'meal_system_id', 'id');
    }
}
