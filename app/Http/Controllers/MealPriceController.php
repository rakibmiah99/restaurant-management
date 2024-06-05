<?php

namespace App\Http\Controllers;

use App\Exports\CompanyExport;
use App\Exports\MealPriceExport;
use App\Http\Requests\Company\CompanyCreateRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Http\Requests\MealPrice\CreateMealPriceRequest;
use App\Http\Requests\MealPrice\UpdateMealPriceRequest;
use App\MealSystemType;
use App\Models\Company;
use App\Models\Country;
use App\Models\MealPrice;
use App\Models\MealSystem;
use App\Models\MealSystemForMealPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MealPriceController extends Controller
{
    public function index(Request $request){
        $columns = (new MealPrice())->getColumns();
        $data = MealPrice::filter()->paginate($request->perpage ?? 10)->withQueryString();
        return view('meal_price.index', compact('data', 'columns'));
    }

    public function show($id){
        $meal_price = MealPrice::find($id);
        if (!$meal_price){
            abort(404);
        }


        return response()->json($meal_price->load(['meal_systems' => function($query){
            $query->with('meal_system');
        }, 'country']));
    }


    function mealSystemByMealPrice(Request $request){
        $meal_price_id = $request->meal_price_ids;

        $GLOBALS['htmls'] = '<select name="hall_id" required id="hall_id" class="form-control select-2"><option value="">' . __('page.select') . '</option>';
        MealSystemForMealPrice::whereIn('meal_price_id', $meal_price_id)->get()->each(function ($mealSystemForMealPrice){
            $meal_system = $mealSystemForMealPrice->meal_system;
            $GLOBALS['htmls'] .= "<option type='$meal_system->type' price='$mealSystemForMealPrice->price' value='$mealSystemForMealPrice->id'>";
            $GLOBALS['htmls'].= $meal_system->name ." - ".ucwords($meal_system->type);
            $GLOBALS['htmls'].= "</option>";
        });

        $GLOBALS['htmls'] .= '</select>';

        echo $GLOBALS['htmls'];
    }


    public function choose(){
        return view('meal_price.choose');
    }


    public function create(Request $request)
    {
        $countries = Country::get();
        if ($request->get('meal-type') == MealSystemType::NORMAL->value){
            $meal_systems = MealSystem::where('type', MealSystemType::NORMAL->value)->get();
            return view('meal_price.normal.create', compact('countries',  'meal_systems'));
        }
        if ($request->get('meal-type') == MealSystemType::RAMADAN->value){
            $meal_systems = MealSystem::where('type', MealSystemType::RAMADAN->value)->get();
            return view('meal_price.ramadan.create', compact('countries', 'meal_systems'));
        }
    }

    public function edit($id, Request $request)
    {
        $meal_price = MealPrice::find($id);
        if (!$meal_price){
            abort(404);
        }
        $countries = Country::get();

        $meal_systems = $meal_price->meal_systems ?? [];

        return view('meal_price.edit', compact('countries', 'meal_price', 'meal_systems'));
    }


    public function store(CreateMealPriceRequest $request){

        DB::beginTransaction();
        try {
            $meal_price = $request->only(['type','code', 'name', 'country_id', 'service_type', 'status']);
            $meal_price =  MealPrice::create($meal_price);
            $meal_prices_data = $request->only(['meal_systems' , 'meal_system_price']);

            $meal_system_for_meal_price = [];
            foreach ($meal_prices_data['meal_systems'] as $key=>$meal_system){
                $price = $meal_prices_data['meal_system_price'][$key];
                $meal_system_for_meal_price [] = [
                    'meal_system_id' => $meal_system,
                    'price' => $price,
                    'meal_price_id' => $meal_price->id
                ];
            }

            foreach ($meal_system_for_meal_price as $item){
                MealSystemForMealPrice::create($item);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Company Created Successfully');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage())->withInput($request->all());
        }
    }


    public function update($id, UpdateMealPriceRequest $request){
        DB::beginTransaction();
        $meal_price = MealPrice::find($id);
        if (!$meal_price){
            abort(404);
        }


        try{
            $meal_price_data = $request->only(['code', 'name', 'country_id', 'service_type', 'status']);
            $meal_price->update($meal_price_data);
            $meal_prices_data = $request->only(['meal_systems' , 'meal_system_price']);
            $meal_system_for_meal_price = [];
            foreach ($meal_prices_data['meal_systems'] as $key=>$meal_system){
                $price = $meal_prices_data['meal_system_price'][$key];
                $meal_system_for_meal_price [] = [
                    'meal_system_id' => $meal_system,
                    'price' => $price,
                    'meal_price_id' => $meal_price->id
                ];
            }



            foreach ($meal_system_for_meal_price as $item){
                $item = collect($item);
                MealSystemForMealPrice::updateOrCreate($item->except(['price'])->toArray(), $item->only('price')->toArray());
            }
            DB::commit();

            return redirect()->back()->with('success', 'Company Updated Successfully');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage())->withInput($request->all());
        }
    }


    public function delete($id){
        $meal_price = MealPrice::find($id);
        if (!$meal_price){
            abort(404);
        }
        $meal_price->delete();

        return redirect()->back()->with('success', "Company Deleted Successfully");
    }

    public function changeStatus($id){
        $meal_price = MealPrice::find($id);
        if (!$meal_price){
            abort(404);
        }

        $meal_price->status = !$meal_price->status;
        $meal_price->save();
        return redirect()->back()->with('success', "status successfully updated");
    }


    //for export to pdf and Excel file
    public function export(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new MealPriceExport(), 'meal_price.xlsx');
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new MealPriceExport(), 'meal_price.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }

    }


}
