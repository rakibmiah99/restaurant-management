<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\CompanyCreateRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Http\Requests\Invoice\InvoiceCreateRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\MealPrice;
use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    public function index(Request $request){
        $columns = (new Company())->getColumns();
        $data = Company::filter()->paginate($request->perpage ?? 10)->withQueryString();
        return view('invoice.index', compact('data', 'columns'));
    }

    public function show($id){
        $company =  Company::find($id);
        if (!$company){
            abort(500, 'ff');
        }
        return response()->json($company);
    }

    public function create(Request $request)
    {
        $order_id = $request->order_id;
        $orders = Order::get()->where('is_complete', true);
        $order = Order::find($order_id);
        $countries = Country::get();
        $meal_prices = MealPrice::active()->get();
//        return $order->available_meal_systems;
        return view('invoice.create', compact('orders','order','countries', 'meal_prices'));
    }

    public function edit($id, Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $company = Company::find($id);
        if (!$company){
            abort(404);
        }
        $countries = Country::get();
        $meal_prices = MealPrice::active()->get();
        return view('invoice.edit', compact('countries', 'meal_prices', 'company'));
    }


    public function store(InvoiceCreateRequest $request){

        return $request->validated();
        try {
            Company::create($request->validated());
            return redirect()->back()->with('success', 'Company Created Successfully');
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage())->withInput($request->all());
        }
    }


    public function update($id, CompanyUpdateRequest $request){
        $company = Company::find($id);
        if (!$company){
            abort(404);
        }
        $company->update($request->validated());
        return redirect()->back()->with('success', 'Company Updated Successfully');
    }


    public function delete($id){
        $company =  Company::find($id);
        if (!$company){
            abort(404);
        }
        $company->delete();

        return redirect()->back()->with('success', "Company Deleted Successfully");
    }

    public function changeStatus($id){
        $company =  Company::find($id);
        if (!$company){
            abort(404);
        }

        $company->status = !$company->status;
        $company->save();
        return redirect()->back()->with('success', "status successfully updated");
    }


    //for export to pdf and Excel file
    public function export(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new \App\Exports\PDF\CompanyExport(), 'company.xlsx');
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new \App\Exports\PDF\CompanyExport(), 'company.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }
}
