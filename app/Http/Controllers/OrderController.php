<?php

namespace App\Http\Controllers;

use App\Exports\HallExport;
use App\Http\Requests\Hall\CreateHallRequest;
use App\Http\Requests\Hall\UpdateHallRequest;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Models\Company;
use App\Models\Country;
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
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(){
        $columns = (new Order())->getColumns();
        $data = Order::filter()->paginate($request->perpage ?? 10)->withQueryString();
        return view('order.index', compact('data', 'columns'));
    }

    public function choose(){
        return view('order.choose');
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

    public function edit($id, Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $hall = Hall::find($id);
        if (!$hall){
            abort(404);
        }
        $hotels = Hotel::all();
        return view('hall.edit', compact('hall', 'hotels'));
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
                $meal_system_price = $meal_system_for_meal_price->price;
                $meal_system_id = $meal_system_for_meal_price->meal_system_id;
                $meal_system = MealSystem::find($meal_system_id);
                $allow_meal = $meal_system->allowMealSystem;
                $orderWiseMealPricesData [] = [
                    'price' => $meal_system_price,
                    'meal_system_id' => $meal_system_id,
                    'order_id' => $order->id
                ];

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
}
