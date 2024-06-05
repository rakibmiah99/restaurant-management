<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMealSystem extends Model
{
    use HasFactory;

    public function meal_system(){
        return $this->belongsTo(MealSystem::class, 'order_meal_system_id', 'id');
    }
}
