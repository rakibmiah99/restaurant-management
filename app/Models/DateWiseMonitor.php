<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DateWiseMonitor extends Model
{
    use HasFactory;

    public function scopeFilter(Builder $builder)
    {
        $request = request();
        $builder->with(['order' => function ($order) use($request) {
            if ($hotel_id = $request->get('hotel')){
                $order->where('hotel_id', $hotel_id);
            }
            if ($hall_id = $request->get('hall')){
                $order->where('hall_id', $hall_id);
            }
            if ($country_id = $request->get('country')){
                $order->where('country_id', $country_id);
            }
        }, 'meal_entries'])->whereDate('meal_date', '>=', date('Y-m-d'))
            ->orderBy('meal_date')
            ->orderBy('order_id', 'desc');

        if ($meal_system_id = $request->get('meal_system')){
            $builder->where('meal_system_id', $meal_system_id);
        }

        if ($request->get('from_date') && $request->get('to_date')){
            $builder->whereBetween('meal_date', [$request->get('from_date'), $request->get('to_date')]);
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

    public function getInHallAttribute(){
        return $this->meal_entries()
            ->whereDate('taken_date', date('Y-m-d'))
            ->whereBetween('taken_time', [date('H:i:s', strtotime('-30 minutes')), date('H:i:s')])
            ->count();
    }
}
