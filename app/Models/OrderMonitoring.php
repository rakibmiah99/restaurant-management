<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderMonitoring extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function meal_system(){
        return $this->belongsTo(MealSystem::class, 'meal_system_id', 'id');
    }


    public static function KitchenQuery()
    {
        $query =  DB::table('order_monitorings as om')
            ->join('orders as o', 'o.id', '=', 'om.order_id')
            ->select(
                'o.service_type',
                DB::raw('(select countries.name from countries where countries.id = o.country_id) as country'),
                DB::raw("SUM(CASE WHEN om.meal_system_id = 5 THEN om.number_of_guest END) AS breakfast"),
                DB::raw("SUM(CASE WHEN om.meal_system_id = 6 THEN om.number_of_guest END) AS lunch"),
                DB::raw("SUM(CASE WHEN om.meal_system_id = 7 THEN om.number_of_guest END) AS dinner"),
                DB::raw("SUM(CASE WHEN om.meal_system_id = 9 THEN om.number_of_guest END) AS seheri"),
                DB::raw("SUM(CASE WHEN om.meal_system_id = 10 THEN om.number_of_guest END) AS iftar"),
                DB::raw("SUM(om.number_of_guest) AS total_meal"),
            )
            ->groupBy(['o.service_type', 'o.country_id']);

        if (request()->from_meal_date && request()->to_meal_date && request()->from_meal_date <= request()->to_meal_date){
            $query->whereBetween('om.meal_date', [\request()->from_meal_date, \request()->to_meal_date]);
        }
        else if(request()->from_meal_date > request()->to_meal_date){
            $query->whereBetween('om.meal_date', [null, null]);
        }
        if ($country_id = \request()->country){
            $query->where('o.country_id', $country_id);
        }
        if ($service_type = \request()->service_type){
            $query->where('o.service_type', $service_type);
        }

        return $query;
    }
}
