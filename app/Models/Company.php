<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use App\Observers\CompanyObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Model;
#[ObservedBy([CompanyObserver::class])]
class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeFilter(Builder $builder){
        $request = request();
        if ($q = $request->q){
            $builder->where('name', 'like', '%'.$q."%");
        }
    }



    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function meal_price(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MealPrice::class, 'meal_price_id', 'id');
    }





    public static function GenerateUniqueID(){
        $company = Company::orderBy('id', 'desc')->first();
        $uniqueID = "1000";
        if ($company){
            $uniqueID = $company->unique_id+1;
        }

        return $uniqueID;
    }

}
