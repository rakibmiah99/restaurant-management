<?php

namespace App\Models;

use App\Model;
use App\Observers\MealPriceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([MealPriceObserver::class])]
class MealPrice extends Model
{
    use HasFactory;
    protected $guarded = [];
    function scopeActive(Builder $builder){
        $builder->where('status', true);
    }

    function scopeFilter(Builder $builder)
    {
        $request = request();
        if ($q = $request->q){
            $builder->where('name', 'like', '%' . $q . "%");
        }
    }

    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function meal_systems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MealSystemForMealPrice::class, 'meal_price_id', 'id');
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
