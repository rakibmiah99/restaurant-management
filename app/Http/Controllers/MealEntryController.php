<?php

namespace App\Http\Controllers;

use App\Models\MealEntries;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MealEntryController extends Controller
{
    public function take($token)
    {
        try {
            $date = date("Y-m-d");
            $data =  OrderController::DecryptGuestPosition($token);
            $guest_info = OrderController::DecryptGuestPosition($token, true);
            $guest_name = OrderController::makeGuestName($data->order_id, $data->index, $data->meal_system_id, $data->position);
            $order_id = $data->order_id;
            $meal_system_id = $data->meal_system_id;
            $order = Order::find($order_id);
            if (!$order) {
                return 'Order not found';
            }
            $meal_system_with_price = $order->meal_systems->where('order_meal_system_id', $meal_system_id)->first();
            $running_meal = $order->hall->running_meal;
            $allow_meals = $meal_system_with_price?->meal_system->allow_meal_system ?? [];
            $allow_meals = collect($allow_meals);
            $is_exist_running_meal_in_allow_meal = $allow_meals->contains('id', $running_meal);
            if (!$is_exist_running_meal_in_allow_meal){
                throw new \Exception('no meal found');
            }

            $today_meal_info =  $order->date_and_meal_wise_order_monitor
                ->where('order_meal_system_id', $meal_system_id)
                ->where('meal_date', $date)->first();


            $taken_meal = $order->meal_entries->where('taken_date', $date)
                ->where('guest_info', $guest_info)
                ->where('order_meal_system_id', $meal_system_id)
                ->where('meal_system_id', $running_meal)
                ->count();
//            $taken_meal = $order->guest_wise_taken_meal->where('taken_date', $date)->where('order_meal_system_id', $meal_system_id)->count();

            if(!$today_meal_info){
                throw new \Exception('today no meal found!');
            }

            if($taken_meal > $today_meal_info->number_of_guest){
                throw new \Exception('already all meal taken!');
            }


            $meal_system = $meal_system_with_price->meal_system;

            if (MealEntries::where([
                'guest_info' => $guest_info,
                'taken_date' => date('Y-m-d'),
                'order_id' => $order_id,
                'order_meal_system_id' => $meal_system->id,
                'meal_system_id' => $running_meal
            ])->count()){
                throw new \Exception('meal already taken');
            }


            $data = [
                'guest_name' => $guest_name,
                'guest_info' => $guest_info,
                'taken_date' => date('Y-m-d'),
                'taken_time' => date('H:i:s'),
                'order_id' => $order_id,
                'order_meal_system_id' => $meal_system->id,
                'meal_system_id' => $running_meal
            ];

            DB::beginTransaction();
            MealEntries::create($data);
            DB::commit();

            return redirect()->back()->with('success', 'meal taken successfully');
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }

    }
}
