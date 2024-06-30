<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateWiseMonitor extends Model
{
    use HasFactory;

    public function scopeFilter(Builder $builder)
    {
        $request = request();
        $builder->with(['order.hall', 'meal_entries'])
            ->whereHas('order', function ($order) use($request) {
                if ($hotel_id = $request->get('hotel')){
                    $order->where('hotel_id', $hotel_id);
                }
                if ($hall_id = $request->get('hall')){
                    $order->where('hall_id', $hall_id);
                }
                if ($country_id = $request->get('country')){
                    $order->where('country_id', $country_id);
                }
            })
//            ->whereHas('order.hall', function (Builder $hall) use($builder){
//                $builder->where('meal_date', '=', date('Y-m-d'));
////                $hall->where('id', 1);
//            })
            ->whereDate('meal_date', '>=', date('Y-m-d'))
            ->orderBy('meal_date')
            ->orderBy('order_id', 'desc');

        if ($meal_system_id = $request->get('meal_system')){
            $builder->where('meal_system_id', $meal_system_id);
        }

        if ($request->get('from_date') && $request->get('to_date')){
            $builder->whereBetween('meal_date', [$request->get('from_date'), $request->get('to_date')]);
        }
    }


    public function scopeInputFilter(Builder $builder){
        $request = request();
        if ($q = trim($request->q)) {
            $meal_system_id = null;
            $meal_system_name = strtolower($q);
            if ($meal_system_name == "breakfast"){
                $meal_system_id = 5;
            }
            else if ($meal_system_name == "lunch"){
                $meal_system_id = 6;
            }
            else if ($meal_system_name == "dinner"){
                $meal_system_id = 7;
            }
            else if ($meal_system_name == "seheri"){
                $meal_system_id = 9;
            }
            else if ($meal_system_name == "iftar"){
                $meal_system_id = 10;
            }

            foreach (array_keys(__('db.order_monitoring')) as $column){
                if ($column == 'order_number'){
                    $builder->orWhereRelation('order','order_number', 'like', "%{$q}%");
                }
                elseif ($column == 'meal_date'){
                    $builder->orWhereDate('meal_date', $q);
                }
                elseif ($column == 'meal_date'){
                    $builder->orWhereDate('meal_date', $q);
                }
                elseif ($column == 'meal_system_id' && $meal_system_id){
                    $builder->orWhere('meal_system_id', $meal_system_id);
                }

            }
        }
    }


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function meal_system(){
        return $this->belongsTo(MealSystem::class, 'meal_system_id', 'id');
    }

    public function meal_entries()
    {
        return $this->hasMany(MealEntries::class, 'order_id', 'order_id')
            ->where('taken_date', '=', $this->meal_date)
            ->where('meal_system_id', '=', $this->meal_system_id);
    }

    public function getTotalTakenAttribute(){
        return $this->meal_entries()->count();
    }
    public function getExecutionStatusAttribute(){
//        $this->
    }




    public function getInHallAttribute(){
        return $this->meal_entries()
            ->whereDate('taken_date', date('Y-m-d'))
            ->whereBetween('taken_time', [date('H:i:s', strtotime('-30 minutes')), date('H:i:s')])
            ->count();
    }
}
