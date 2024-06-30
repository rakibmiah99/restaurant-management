<?php

namespace App\Models;

use App\Enums\Status;
use App\Model;
use App\Models\Scopes\DescScope;
use App\Observers\HotelObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([HotelObserver::class]), ScopedBy(DescScope::class)]
class Hotel extends Model
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
                if ($column == 'status' && (strtolower($q) == strtolower(Status::ACTIVE->value) || strtolower($q) == strtolower(Status::INACTIVE->value))){
                    $status = strtolower($q) == strtolower(Status::ACTIVE->value) ? 1 : 0;
                    $builder->orWhere('status', $status);
                }
                else{
                    $builder->orWhere($column, 'like', '%'.$q."%");
                }
            }
        }
    }


    public function halls(){
        return $this->hasMany(Hall::class, 'hotel_id', 'id');
    }

    public static function GenerateUniqueCode(){
        $model = Hotel::orderBy('id', 'desc')->first();
        $code = "1000";
        if ($model){
            $code = $model->code+1;
        }

        return $code;
    }
}
