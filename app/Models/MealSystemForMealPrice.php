<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealSystemForMealPrice extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'meal_system_for_meal_price';
    public $incrementing = true;
    protected $primaryKey = 'id';


    public function meal_system(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MealSystem::class, 'meal_system_id', 'id');
    }
}
