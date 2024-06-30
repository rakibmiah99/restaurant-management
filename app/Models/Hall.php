<?php

namespace App\Models;

use App\Enums\Status;
use App\MealSystemType;
use App\Model;
use App\Models\Scopes\DescScope;
use App\Observers\HallObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([HallObserver::class]), ScopedBy(DescScope::class)]
class Hall extends Model
{
    use HasFactory;
    protected $guarded = [];

    function scopeActive(Builder $builder){
        $builder->where('status', true);
    }
    public function scopeFilter(Builder $builder){
        $request = request();
        if ($q = trim($request->q)) {
            foreach ($this->getColumns() as $column){
                if ($column == 'hotel_id'){
                    $builder->orWhereRelation('hotel', 'name', 'like', '%'.$q."%");
                }
                elseif ($column == 'status' && (strtolower($q) == strtolower(Status::ACTIVE->value) || strtolower($q) == strtolower(Status::INACTIVE->value))){
                    $status = strtolower($q) == strtolower(Status::ACTIVE->value) ? 1 : 0;
                    $builder->orWhere('status', $status);
                }
                else{
                    $builder->orWhere($column, 'like', '%'.$q."%");
                }

            }
        }
    }


    public function hotel(){
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }


    function getRunningMealAttribute()
    {
        $meal_system_id = null;
        $starting_time = null;
        $ending_time = null;
        $now =  date('H:i:s');
        if( $this->b_start <= $now && $this->b_end > $now){
            $meal_system_id = 5;
        }
        else if($this->l_start <= $now && $this->l_end > $now){
            $meal_system_id = 6;
        }
        else if($this->d_start <= $now && $this->d_end > $now){
            $meal_system_id = 7;
        }
        else if($this->s_start <= $now && $this->s_end > $now){
            $meal_system_id = 9;
        }
        else if($this->i_start <= $now && $this->d_end > $now){
            $meal_system_id = 10;
        }


        return $meal_system_id;

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
            else if($now < $this->i_start){
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
