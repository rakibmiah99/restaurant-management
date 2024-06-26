<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Hotel;
use App\Models\MealSystem;
use App\Models\Order;
use App\Models\OrderMonitoring;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function page()
    {
        $today = date('Y-m-d');
        $after7days = date('Y-m-d', strtotime('+6 days'));

        $next7days_date = collect(CarbonPeriod::create($today, $after7days))->map(function ($date){return $date->format('Y-m-d');});


        $next7days_main_meal_system_data = MealSystem::where('is_main', true)->get()->map(function ($item) use($today, $after7days, $next7days_date) {
            $date_wise_meals = [];
            foreach ($next7days_date as $date) {
                $date_wise_meals [] = OrderMonitoring::where('meal_system_id', $item->id)->whereDate('meal_date', $date)->sum('number_of_guest');
            }

            return (object)[
                'label' => $item->name,
                'data' => $date_wise_meals
            ];
        });


//        return $next7days_main_meal_system_data;




        $total_company = Company::count('id');
        $total_hotel = Hotel::count('id');
        $orders = Order::with(['hotel', 'hall', 'meal_systems', 'country', 'order_monitoring'])->get();
        $total_complete_order = $orders->where('is_complete', true)->count();
        $total_today_order = $orders->where('order_date', date('Y-m-d'))->count();
        $next7days_total_order = $orders->whereBetween('order_date', [$today, $after7days])->count();
        $total_guest =  $orders->sum('total_guest');


        return view('dashboard', compact('total_company', 'total_hotel', 'total_complete_order', 'total_today_order', 'total_guest', 'next7days_total_order', 'next7days_date', 'next7days_main_meal_system_data'));
    }
}
