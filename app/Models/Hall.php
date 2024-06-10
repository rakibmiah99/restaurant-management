<?php

namespace App\Models;

use App\MealSystemType;
use App\Model;
use App\Observers\HallObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([HallObserver::class])]
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


    function getRunningMealNameAttribute()
    {
        $meal_type = "";
        $starting_time = null;
        $ending_time = null;
        $now =  date('H:i:s');
        if( $this->b_start <= $now && $this->b_end > $now){
            $meal_type = 'breakfast';
            $starting_time = $this->break_fast_starting_time;
            $ending_time = $this->break_fast_ending_time;
        }
        else if($this->l_start <= $now && $this->l_end > $now){
            $meal_type = 'lunch';
            $starting_time = $this->lunch_starting_time;
            $ending_time = $this->lunch_ending_time;
        }
        else if($this->d_start <= $now && $this->d_end > $now){
            $meal_type = 'dinner';
            $starting_time = $this->dinner_starting_time;
            $ending_time = $this->dinner_ending_time;
        }
        else if($this->s_start <= $now && $this->s_end > $now){
            $meal_type = 'dinner';
            $starting_time = $this->dinner_starting_time;
            $ending_time = $this->dinner_ending_time;
        }
        else if($this->i_start <= $now && $this->d_end > $now){
            $meal_type = 'dinner';
            $starting_time = $this->dinner_starting_time;
            $ending_time = $this->dinner_ending_time;
        }


        return $meal_type;

    }

    function getMealSystemAttribute($type = MealSystemType::NORMAL->value)
    {
        $meal_systems = [];
        $now =  date('H:i:s');

        if ($type == MealSystemType::NORMAL->value){
            if( $now < $this->b_start ){
                $meal_systems = MealSystem::GetAllForNormal();
            }
            else if($now < $this->l_start){
                $meal_systems = MealSystem::GetAfterBreakfast();
            }
            else if($now < $this->d_start){

                $meal_systems = MealSystem::GetAfterLunch();
            }
        }
        else if ($type == MealSystemType::RAMADAN->value){
            if($now < $this->s_start){
                $meal_systems = MealSystem::GetAllForRamadan();
            }
            else if($now < $this->s_end){
                $meal_systems = MealSystem::GetAfterSeheri();
            }
        }

        return $meal_systems;

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
