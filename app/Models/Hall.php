<?php

namespace App\Models;

use App\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hall extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeFilter(Builder $builder){
        $request = request();
        if ($q = $request->q){
            $builder->where('name', 'like', '%'.$q."%");
        }
    }


    public function hotel(){
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }

    public function meal_times(){
        return $this->hasMany(HallMealTime::class, 'hall_id', 'id');
    }


    public static function GenerateUniqueCode(){
        $model = MealPrice::orderBy('id', 'desc')->first();
        $code = "1000";
        if ($model){
            $code = $model->code+1;
        }

        return $code;
    }
}
