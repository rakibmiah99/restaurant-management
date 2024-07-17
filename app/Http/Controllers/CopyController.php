<?php

namespace App\Http\Controllers;

use App\Enums\UserTypeEnum;
use App\Models\Company;
use App\Models\Country;
use App\Models\Hall;
use App\Models\Hotel;
use App\Models\MealPrice;
use App\Models\User;
use App\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return $this->meal_price->get()->each(function ($item){
            $data = [
                'id' => $item->id,
                'name' => $item->pricing_name,
                'code' => $item->pricing_code,
                'service_type' => $item->food_type,
                'country_id' => $item->country_id,
                'status' => $this->status($item->status),
                'created_by' => $this->created_by
            ];
            MealPrice::create($data);
        });
    }

    public function company(){
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



    public function status($status){
        return $status == "active" || $status == 1 ? 1 :  0;
    }
}
