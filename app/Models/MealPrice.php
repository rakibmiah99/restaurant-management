<?php

namespace App\Models;

use App\Enums\Status;
use App\Model;
use App\Models\Scopes\DescScope;
use App\Observers\MealPriceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([MealPriceObserver::class]), ScopedBy(DescScope::class)]
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
        if ($q = trim($request->q)){
            foreach ($this->getColumns() as $column){
                if ($column == 'country_id'){
                    $builder->orWhereRelation('country', 'name', 'like', '%'.$q."%");
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
