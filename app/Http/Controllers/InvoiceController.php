<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\CompanyCreateRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Http\Requests\Invoice\InvoiceCreateRequest;
use App\Models\Company;
use App\Models\CompanySetting;
use App\Models\Country;
use App\Models\Invoice;
use App\Models\InvoiceData;
use App\Models\MealPrice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class InvoiceController extends Controller
{
    public function index(Request $request){
        $columns = array_keys(__('db.invoice'));
        $data = Invoice::filter()->paginate($request->perpage ?? 10)->withQueryString();
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
        if (Invoice::where('order_id', $order_id)->exists()){
            return $this->errorMessage('already generated invoice');
        }
        $orders = Order::get()->where('is_complete', true);
        $order = Order::find($order_id);
        $available_meal_systems =  $order?->available_meal_systems;
        //calculation start
        $tax_percentage = CompanySetting::first()?->tax ?? 0;
        $total =  $available_meal_systems?->sum('total_price');
        $tax_amount = $total * $tax_percentage / 100;
        $total_with_tax = $total + $tax_amount;
        $tax_amount = number_format($tax_amount, 2);
        //calculation end
        return view('invoice.create', compact('orders','order', 'total', 'total_with_tax', 'tax_amount', 'tax_percentage', 'available_meal_systems'));
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
        DB::beginTransaction();
        try {
            $order_id = $request->order_id;
            $order = Order::find($order_id);
            $available_meal_systems =  $order->available_meal_systems;
            $invoice_data = [
                'order_id' => $order_id,
                'invoice_number' => Invoice::GenerateInvoiceNumber(),
                'invoice_date' => $request->invoice_date,
                'discount' => $request->discount,
                'tax' => CompanySetting::first()?->tax ?? 0,
            ];

            $invoice = Invoice::create($invoice_data);
            $invoice_data = [];
            for ($i =0; $i < count($request->meal_system_id); $i++){
                $meal_system_id = $request->meal_system_id[$i];
                $price = $request->price[$i];
                $meal_system_data = $available_meal_systems->where('meal_system_id', $meal_system_id)->first();
                $total_meal = $meal_system_data?->count_of_meal ?? 0;
                $invoice_data [] = [
                    'invoice_id' => $invoice->id,
                    'meal_system_id' => $meal_system_id,
                    'total_meal' => $total_meal,
                    'price' => $price,
                    'total_price' => $total_meal * $price
                ];
            }

            InvoiceData::insert($invoice_data);
            DB::commit();
            return redirect()->route('invoice.index')->with('success', 'Created Successfully');
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
