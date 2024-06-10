<?php

namespace App\Http\Controllers;

use App\Exports\HallExport;
use App\Helper;
use App\Http\Requests\Hall\CreateHallRequest;
use App\Http\Requests\Hall\UpdateHallRequest;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\DateAndMealSWiseMonitor;
use App\Models\Hall;
use App\Models\Hotel;
use App\Models\MealPrice;
use App\Models\MealSystem;
use App\Models\MealSystemForMealPrice;
use App\Models\Order;
use App\Models\OrderMonitoring;
use App\Models\OrderWiseMealPrice;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(){
        $columns = (new Order())->getColumns();
        $data = Order::filter()->paginate($request->perpage ?? 10)->withQueryString();
        return view('order.index', compact('data', 'columns'));
    }

    public function showQR($id)
    {
        $order = Order::find($id);
        if (!$order){
            abort(404);
        }

        $per_page_data = 10;
        $data =  $this->getGuestPosition($order);
        $data = Helper::Paginate($data, $per_page_data);


        return view('order.show_qr', compact('data', 'order', 'per_page_data'));
    }

    public function showGuestQr($code)
    {
        return self::DecryptGuestPosition($code);
    }

    public function choose(){
        return view('order.choose');
    }

    public function modifyGuest($id, Request $request){

        if($request->from_date < date('Y-m-d')){
            $request->from_date = date('Y-m-d');
        }


        $order = Order::find($id);


        $startDate = Carbon::create($request->from_date);
        $endDate = Carbon::create($request->to_date);

        // Calculate the difference in days
        $dateDifference = $startDate->diffInDays($endDate);


        // Create a period instance for the range
        $period = CarbonPeriod::create($startDate, $endDate);

//        return $order->meal_price_wise_meal_systems;
        $date_wise_meals =  $order->date_and_meal_wise_order_monitor->whereBetween('meal_date', [$request->from_date, $request->to_date]);
        if ($request->meal_system){
            $date_wise_meals = $date_wise_meals->where('order_meal_system_id', $request->meal_system);
        }
        $GLOBALS['date_wise_meal_data'] = [];
        // Loop through each day in the range
        foreach ($period as $date) {
            // Perform operations for each day
            $date = $date->format('Y-m-d') ;
            $meal_data = $date_wise_meals->where('meal_date', $date);

            if (!$meal_data->count()){
                $GLOBALS['date_wise_meal_data'] [] = (object)[
                    'number_of_guest' => 0,
                    'meal_system_type' => '',
                    'meal_date' => $date,
                    'meal_system_name' => '',
                    'meal_system_for_meal_price_id' => null,
                    'order_meal_system_id' => null,
                    'price' => 0,
                ];
            }
            else{
                $meal_data->each(function ($item){
                    $GLOBALS['date_wise_meal_data'] [] = (object)[
                        'number_of_guest' => $item->number_of_guest,
                        'meal_system_type' => $item->meal_system_type,
                        'meal_date' => $item->meal_date,
                        'meal_system_name' => $item->meal_system->name."-".$item->meal_system->type,
                        'order_meal_system_id' => $item->meal_system->id,
                        'meal_system_for_meal_price_id' => $item->meal_system_for_meal_price_id,
                        'price' => $item->price,
                    ];
                });
            }


        }
        $date_wise_meal_data =  $GLOBALS['date_wise_meal_data'];

//        return $order->meal_price_wise_meal_systems;

        if (!$order){
            abort(404);
        }
        $meal_systems = MealSystem::get()->map(function ($item){
           $item->name = $item->name."-".$item->type;
           return $item;
        });
        return view('order.modify_guest', compact('order', 'meal_systems', 'date_wise_meal_data'));
    }


    public function updateModifyGuest($id, Request $request){
        $order = Order::find($id);
        if (!$order){
            abort(404);
        }

        DB::beginTransaction();
        try {
            $meal_dates = $request->meal_date;
            $number_of_guests = $request->number_of_guest;
            $from_meal_systems = $request->from_meal_system_id;
            $to_meal_systems = $request->to_meal_system;
            $orderMonitorData = [];
            for ($i = 0; $i < count($meal_dates); $i++){
                $date = $meal_dates[$i];
                $guest = $number_of_guests[$i];
                $from_meal_system = $from_meal_systems[$i];
                $to_meal_system = $to_meal_systems[$i];
                if (!$to_meal_system || !$date || !$guest){
                    continue;
                }



                // Find existing meal system by from_meal_system_id and get first guest number
                $from_order_monitor = $order->order_monitoring->where('meal_date', $date)
                    ->where('order_meal_system_id', $from_meal_system)
                    ->first();

                $fromExistGuest = ($from_meal_system == $to_meal_system) ?  0 :  ($from_order_monitor?->number_of_guest ?? 0);


                // Find existing meal system by to_meal_system_id and get first guest number
                $order_monitor = $order->order_monitoring->where('meal_date', $date)
                    ->where('order_meal_system_id', $to_meal_system)
                    ->first();


                $existGuest = ($from_meal_system == $to_meal_system) ?  0 :  ($order_monitor?->number_of_guest ?? 0);

                // Remove previous monitoring data
                OrderMonitoring::where([
                    'order_id' => $order->id,
                    'meal_date' =>  $date,
                    'order_meal_system_id' => $from_meal_system
                ])->delete();

                // Remove existing monitoring data for the new meal system
                OrderMonitoring::where([
                    'order_id' => $order->id,
                    'meal_date' =>  $date,
                    'order_meal_system_id' => $to_meal_system
                ])->delete();
                if ($from_order_monitor?->number_of_guest > $guest && $from_meal_system != $to_meal_system){

                    /** for update from meal system */
                    //get allowed meal systems
                    $meal_system = MealSystem::find($from_meal_system);
                    $allowed_meal_system = $meal_system->allowMealSystem;

                    // Prepare data for batch insertion
                    foreach ($allowed_meal_system as $meal){
                        $orderMonitorData [] = [
                            'order_id' => $order->id,
                            'meal_system_type' => $meal_system->type,
                            'number_of_guest' => $fromExistGuest-$guest,
                            'meal_date' => $date,
                            'order_meal_system_id' => $meal_system->id,
                            'meal_system_id' => $meal->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }


                    /** for update to meal system */
                    //get allowed meal systems
                    $meal_system = MealSystem::find($to_meal_system);
                    $allowed_meal_system = $meal_system->allowMealSystem;

                    // Prepare data for batch insertion
                    foreach ($allowed_meal_system as $meal){
                        $orderMonitorData [] = [
                            'order_id' => $order->id,
                            'meal_system_type' => $meal_system->type,
                            'number_of_guest' => $existGuest+$guest,
                            'meal_date' => $date,
                            'order_meal_system_id' => $meal_system->id,
                            'meal_system_id' => $meal->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }

                }

                else{
                    //get allowed meal systems
                    $meal_system = MealSystem::find($to_meal_system);
                    $allowed_meal_system = $meal_system->allowMealSystem;

                    // Prepare data for batch insertion
                    foreach ($allowed_meal_system as $meal){
                        $orderMonitorData [] = [
                            'order_id' => $order->id,
                            'meal_system_type' => $meal_system->type,
                            'number_of_guest' => $existGuest+$guest,
                            'meal_date' => $date,
                            'order_meal_system_id' => $meal_system->id,
                            'meal_system_id' => $meal->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }

            }

            // Insert new monitoring data
            OrderMonitoring::insert($orderMonitorData);
            DB::commit();
            return redirect()->back()->with(['success' => 'updated']);
        }
        catch (\Exception $exception){
            DB::rollBack();

            dd($exception->getMessage());
            return redirect()->back()->with(['error' => 'Update failed: ' . $exception->getMessage()]);
        }

    }
    public function show($id){
        $hall = Hall::find($id);
        if (!$hall){
            abort(404);
        }
        return response()->json($hall->load(['hotel']));
    }

    public function create(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $hotels = Hotel::all();
        $companies = Company::all();
        $countries = Country::all();
        $mealPricesNormal = MealPrice::where('type', 'normal')->get();
        $mealPricesRamadan = MealPrice::where('type', 'ramadan')->get();
        return view('order.create', compact(
            'hotels',
            'companies',
            'countries',
            'mealPricesRamadan',
            'mealPricesNormal'
        ));
    }

    public function edit($id, Request $request)
    {
        $order = Order::find($id);
        if (!$order){
            abort(404);
        }


//        return $order->is_modified;

        $hotels = Hotel::all();
        $companies = Company::all();
        $countries = Country::all();
        $mealPricesNormal = MealPrice::where('type', 'normal')->get();
        $mealPricesRamadan = MealPrice::where('type', 'ramadan')->get();
        return view('order.edit', compact(
            'order',
            'hotels',
            'companies',
            'countries',
            'mealPricesRamadan',
            'mealPricesNormal'
        ));
    }


    public function store(CreateOrderRequest $request){
        DB::beginTransaction();


        try {
            $orderData = $request->only([
                'order_number',
                'order_date',
                'country_id',
                'service_type',
                'company_id',
                'hotel_id',
                'hall_id',
                'mpi_for_normal',
                'mpi_for_ramadan',
                'order_note',
                'status',
            ]);

            $order = Order::create($orderData);
            $orderMonitorData = [];
            $orderWiseMealPricesData = [];
            foreach ($request->meal_system_price_id as $key=>$id){
                //make order wise meal system data ;
                $meal_system_for_meal_price = MealSystemForMealPrice::find($id);
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


            OrderWiseMealPrice::insert($orderWiseMealPricesData);
            OrderMonitoring::insert($orderMonitorData);
            DB::commit();
            return redirect()->back()->with('success', 'Hall Created Successfully');
        }
        catch (\Exception $exception){
            dd($exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage())->withInput($request->all());
        }
    }


    public function update($id, UpdateHallRequest $request){
        $hall = Hall::find($id);
        if (!$hall){
            abort(404);
        }
        $hall->update($request->validated());
        return redirect()->back()->with('success', 'Hall Updated Successfully');
    }


    public function delete($id){
        $hall = Hall::find($id);
        if (!$hall){
            abort(404);
        }
        $hall->delete();

        return redirect()->back()->with('success', "Hall Deleted Successfully");
    }

    public function changeStatus($id){
        $hall = Hall::find($id);
        if (!$hall){
            abort(404);
        }

        $hall->status = !$hall->status;
        $hall->save();
        return redirect()->back()->with('success', "status successfully updated");
    }


    //for export to pdf and Excel file
    public function export(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new HallExport(), 'hall.xlsx');
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new HallExport(), 'hall.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }






    public function getGuestPosition($order){
        $GLOBALS['guest'] = [];
        $company = $order->company->name;
        $order->meal_systems->each(function($item, $index) use($company){
            $number_of_guest = $item->number_of_guest;
            $meal_system_id = $item->order_meal_system_id;
            $order_id = $item->order_id;

            $guest_names = [];

            for($i =0; $i < $number_of_guest; $i++){
                $guest_names [] = [
                    'name' => "Guest".$order_id.$index.$i,
                    'code' => self::EncryptGuestPosition($order_id,$index,$meal_system_id,$i),
                ];
            }

            $GLOBALS['guest'] [] = [
                'company' => $company,
                'meal_system' => $item->meal_system->name,
                'names' => $guest_names
            ];

        });

        $meal_system_wise_guest = collect($GLOBALS['guest']);

        return  $all_guest_name =  $meal_system_wise_guest->flatMap->names;
    }



    public static function EncryptGuestPosition($order_id,$index,$meal_system_id,$i){
        return Crypt::encrypt($order_id.$index.$meal_system_id.$i);
    }
    public static function DecryptGuestPosition($enCryptData){
        $data = Crypt::decrypt($enCryptData);
        return (object)[
            'order_id' => $data[0],
            'index' => $data[1],
            'meal_system_id' => $data[2],
            'position' => $data[3],
        ];
    }



}
