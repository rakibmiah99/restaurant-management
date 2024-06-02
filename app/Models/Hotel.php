<?php

namespace App\Models;

use App\Model;
use App\Observers\HotelObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([HotelObserver::class])]
class Hotel extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function scopeFilter(Builder $builder){
        $request = request();
        if ($q = $request->q){
            $builder->where('name', 'like', '%'.$q."%");
        }
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
