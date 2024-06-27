<?php

namespace App\Models;

use App\Enums\Status;
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
        if ($q = trim($request->q)) {
            foreach ($this->getColumns() as $column){
                if ($column == 'country_id'){
                    $builder->orWhereRelation('country', 'name', 'like', '%'.$q."%");
                }
                elseif ($column == 'meal_price_id'){
                    $builder->orWhereRelation('meal_price', 'name', 'like', '%'.$q."%");
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
