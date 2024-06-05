<?php

namespace App\Models;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Model;
use App\Observers\OrderObserver;
use Dflydev\DotAccessData\Data;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeFilter(){

    }




    public function date_and_meal_wise_order_monitor(){
        return $this->hasMany(DateAndMealSWiseMonitor::class, 'order_id', 'id');
    }
    public function order_monitoring(){
        return $this->hasMany(OrderMonitoring::class, 'order_id', 'id');
    }

    public function company(){
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function meal_systems(){
        return $this->hasMany(OrderMealSystem::class, 'order_id', 'id');
    }

    public function hotel(){
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }

    public function hall(){
        return $this->belongsTo(Hall::class, 'hall_id', 'id');
    }

    public function country(){
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    //mpi = meal price id
    public function meal_price_for_normal(){
        return $this->belongsTo(MealPrice::class, 'mpi_for_normal', 'id');
    }

    //mpi = meal price id
    public function meal_price_for_ramadan(){
        return $this->belongsTo(MealPrice::class, 'mpi_for_ramadan', 'id');
    }


    public function getAllMealPriceAttribute(){
        $data = collect([]);
        return $data->concat(
            $this->meal_price_for_normal?->meal_systems ?? [],
        )->concat($this->meal_price_for_ramadan?->meal_systems ?? []);
    }


    public function getMealPriceWiseMealSystemsAttribute(){
        return $this->all_meal_price->map(function ($meal_price){
            $meal_system =  $meal_price->meal_system;
            $meal_system->meal_price_id = $meal_price->id;
            return $meal_system;
        });
    }


    public function getAvailableMealSystemsAttribute(){

        return $data = $this->date_and_meal_wise_order_monitor()
        ->get()->groupBy('order_meal_system_id')
        ->map(function ($meal_system_data, $meal_system_id){
            //finding meal system
            $meal_system = MealSystem::find($meal_system_id);
            if (!$meal_system) {
                return null; // Skip if MealSystem is not found
            }
            //get meal price
            $price = $meal_system_data->first()->price;
            //summation of total guest
            $total_guest = $meal_system_data->sum('number_of_guest');

            //formatting and return data
            return  (object)[
              'name' => $meal_system->name."-".$meal_system->type,
              'days' => $meal_system_data->count('meal_date'),
              'count_of_meal' => $total_guest,
              'price' => $price,
              'total_price' => $total_guest * $price,
            ];
        })->filter();
    }




    static function GenerateOrderNumber()
    {
        $order_number = Order::orderBy('id', 'desc')->first()?->order_number;
        $exp = explode('/', $order_number);
        $year = Hijri::Date('Y');
        $sl = 1;
        if(is_array($exp) && count($exp) == 2){
            $sl = $exp[1];
            $sl++;
        }
        $sl =  str_pad($sl,5,"0",STR_PAD_LEFT );
        return $year."/".$sl;
    }

}
