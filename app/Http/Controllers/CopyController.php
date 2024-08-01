<?php

namespace App\Http\Controllers;

use App\Enums\UserTypeEnum;
use App\Models\Company;
use App\Models\Country;
use App\Models\Hall;
use App\Models\Hotel;
use App\Models\MealPrice;
use App\Models\MealSystem;
use App\Models\OrderMonitoring;
use App\Models\OrderWiseMealPrice;
use App\Models\User;
use App\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MealSystemForMealPrice;
use App\Models\Order;
class CopyController extends Controller
{
    public function __construct()
    {
        $this->connection = DB::connection('another_db');
        $this->hotel = $this->connection->table('restaurants');
        $this->hall = $this->connection->table('halls');
        $this->meal_price = $this->connection->table('meal_types');
        $this->countries = $this->connection->table('countries');
        $this->companies = $this->connection->table('companies');
        $this->meal_systems = $this->connection->table('meal_systems');
        $this->orders = $this->connection->table('orders');
        $this->created_by = User::where('user_type', UserTypeEnum::SYSTEM->value)->first()->id;
    }

    public function hotel(){
        return $this->hotel->get()->each(function ($hotel){
        
            $data = [
                'id' => $hotel->id,
                'name' => $hotel->restaurant_name,
                'code' => $hotel->code,
                'phone' => $hotel->restaurant_phone,
                'email' => $hotel->restaurant_email,
                'address' => $hotel->restaurant_address,
                'status' => $this->status($hotel->status),
                'created_by' => $this->created_by
            ];
            Hotel::create($data);
        });
    }

    public function hall(){
        return $this->hall->get()->each(function ($item){
            $data = [
                'id' => $item->id,
                'name' => $item->hall_name,
                'code' => $item->code,
                'capacity' => $item->hall_capacity,
                'hotel_id' => $item->restaurant_id,
                'b_start' => $item->break_fast_starting_time,
                'b_end' => $item->break_fast_ending_time,
                'l_start' => $item->lunch_starting_time,
                'l_end' => $item->lunch_ending_time,
                'd_start' => $item->dinner_starting_time,
                'd_end' => $item->dinner_ending_time,
                's_start' => "02:00",
                's_end' => "04:00",
                'i_start' => "18:00",
                'i_end' => "23:59",
                'status' => $this->status($item->status),
                'created_by' => $this->created_by
            ];
            Hall::create($data);
        });
    }

    public function meal_price(){
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('meal_prices')->truncate();
        DB::table('meal_system_for_meal_price')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        $exist_meal_systems = MealSystem::where('type', 'normal')->get();
        
        return $this->meal_price->get()->each(function ($item) use($exist_meal_systems){
           
            $data = [
                'id' => $item->id,
                'name' => $item->pricing_name,
                'code' => $item->pricing_code,
                'service_type' => $item->food_type,
                'country_id' => $item->country_id,
                'status' => $this->status($item->status),
                'created_by' => $this->created_by
            ];

            $meal_price = MealPrice::create($data);
            // dd($meal_prices_data);
            // $meal_prices_data = $request->only(['meal_systems' , 'meal_system_price']);
            $meal_prices_data = DB::connection('another_db')->table('meal_systems')->where('meal_type_id', $item->id)->get();
            $meal_system_for_meal_price = [];
            foreach ($exist_meal_systems as $meal_system){
                $price = $meal_prices_data->where('meal_system_id', $meal_system->id)->first()?->price ?? 0;
            
                
                $meal_system_for_meal_price [] = [
                    'meal_system_id' => $meal_system->id,
                    'price' => $price,
                    'meal_price_id' => $meal_price->id
                ];
            }
            // dd($meal_system_for_meal_price);
            foreach ($meal_system_for_meal_price as $item){
                MealSystemForMealPrice::create($item);
            }
        });
    }

    public function company(){
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('companies')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        return $this->companies->get()->each(function ($item){
            $data = [
                'id' => $item->id,
                'name' =>$item->company_name,
                'code' => $item->company_code,
                'address' => $item->company_address,
                'phone' => $item->company_phone,
                'email' => $item->company_email,
                'website' => $item->company_website,
                'tax' => $item->company_tax,
                'agent_name' => $item->representative,
                'agent_mobile' => $item->agent_mobile,
                'country_id' => $item->country_id,
                'meal_price_id' => $item->meal_type_id,
                'status' => $this->status($item->status),
                'created_by' => $this->created_by
            ];
            Company::create($data);
        });
    }

    public function country(){
        return $this->countries->get()->each(function ($item){
            $data = [
                'id' => $item->id,
                'name' => $item->country_name,
                'code' => $item->country_code
            ];
            Country::create($data);
        });
    }


    
    public function orders(){
        // DB::beginTransaction();
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('orders')->truncate();
        DB::table('meal_entries')->truncate();
        DB::table('order_monitorings')->truncate();
        DB::table('order_wise_meal_prices')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        return $this->orders->get()->each(function ($item){
            $orderData = [
                'id' => $item->id,
                'order_number' => $item->order_number,
                'order_date' => $item->order_date,
                'country_id' => $item->country_id,
                'service_type' => $item->service_type,
                'company_id' => $item->company_id,
                'hotel_id' => $item->restaurant_id,
                'hall_id' => $item->hall_id,
                'mpi_for_normal' => $item->meal_type_id,
                // 'mpi_for_ramadan',
                'order_note' => $item->order_note,
                'status' => $this->status( $item->status),
                'created_by' => $this->created_by
            ];

            $order = Order::create($orderData);
            $order_wise_meal_prices = OrderWiseMealPrice::where('order_id', $item->id)->get();
            $order_wise_meal = $this->connection->table('order_wise_meals')->where('order_id', $item->id)->get();
            
            // $order_wise_meal_prices = $this->connection->table('order_wise_meal_system_prices')->where('order_id' , $item->id )->get();
            $GLOBALS['orderMonitorData'] = [];
            $order_wise_meal->each(function($meal_data) use ($item){
                $meal_system_id = $meal_data->meal_system_id;
                $meal_system = MealSystem::find($meal_system_id);
                $allow_meal = $meal_system->allowMealSystem;

                foreach ($allow_meal as $meal){
                    $GLOBALS['orderMonitorData'] [] = [
                        'order_id' => $item->id,
                        'meal_system_type' => $meal_system->type,
                        'number_of_guest' => $meal_data->number_of_guest,
                        'meal_date' => $meal_data->date,
                        'order_meal_system_id' => $meal_data->meal_system_id,
                        'meal_system_id' => $meal->id
                    ];
                }

                
            });

    

            OrderMonitoring::insert($GLOBALS['orderMonitorData']);
        });
    }

    public function GenerateOrderMonitorData($order_meal_prices , $order){
        //        dd($request->meal_system_price_id);
        
                $orderMonitorData = [];
                foreach ($order_meal_prices as $price){
                    //make order wise meal system data ;
                    $meal_system_for_meal_price = MealSystemForMealPrice::find($price->id);
                    if (!$meal_system_for_meal_price){
                        //handle error here
                        dd('error');
                    }
        
                    $meal_system_id = $meal_system_for_meal_price->meal_system_id;
                    $meal_system = MealSystem::find($meal_system_id);
                    $allow_meal = $meal_system->allowMealSystem;
        
                    //make order monitoring data
                    $from_date = $request->from_date[$key];
                    $to_date = $request->to_date[$key];
        
                    $number_of_guest = $request->guest[$key];
        
                    // Define the start and end dates
                    $from_date = Carbon::create($from_date);
                    $to_date = Carbon::create($to_date);
        
                    // Create a period instance for the range
                    $period = CarbonPeriod::create($from_date, $to_date);
        
                    // Loop through each day in the range
                    foreach ($period as $date) {
                        foreach ($allow_meal as $meal){
                            $orderMonitorData [] = [
                                'order_id' => $order->id,
                                'meal_system_type' => $meal_system->type,
                                'number_of_guest' => $number_of_guest,
                                'meal_date' => $date->format('Y-m-d'),
                                'order_meal_system_id' => $meal_system->id,
                                'meal_system_id' => $meal->id
                            ];
                        }
                    }
                }
        
                return $orderMonitorData;
            }


    public function status($status){
        return $status == "active" || $status == 1 ? 1 :  0;
    }
}
