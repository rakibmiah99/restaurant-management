<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Http\Requests\Company\CompanyCreateRequest;
use App\Http\Requests\Company\CompanyUpdateRequest;
use App\Http\Requests\Invoice\InvoiceCreateRequest;
use App\Http\Requests\Invoice\InvoiceUpdateRequest;
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
        $data = Invoice::filter()->paginate(Helper::PerPage())->withQueryString();
        return view('invoice.index', compact('data', 'columns'));
    }

    public function show($id){
        $invoice =  Invoice::find($id);
        if (!$invoice){
            abort(404);
        }
        return view('invoice.show', compact('invoice'));
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

    public function edit($id, Request $request)
    {

        $invoice_id = $request->id;
        $invoice = Invoice::find($invoice_id);
        if (!$invoice){
            abort(404, 'not fond');
        }
        $order = $invoice->order;
        $available_meal_systems =  $invoice?->invoice_data;
        //calculation start
        $tax_percentage = $invoice->tax;
        $total =  $invoice->total_price;
        $tax_amount = $invoice->tax_amount;
        $total_with_tax = $invoice->total_with_tax;
        return view('invoice.edit', compact('invoice','order', 'total', 'total_with_tax', 'tax_amount', 'tax_percentage', 'available_meal_systems'));
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


    public function update($id, InvoiceUpdateRequest $request){
        DB::beginTransaction();
        $invoice = Invoice::find($id);
        if (!$invoice){
            abort(404, 'not fond');
        }
        try {
            $invoice->invoice_date = $request->invoice_date;
            $invoice->discount = $request->discount;
            $invoice->save();
            for ($i =0; $i < count($request->meal_system_id); $i++){
                $meal_system_id = $request->meal_system_id[$i];
                $price = $request->price[$i];
                $invoice->invoice_data()->where('meal_system_id', $meal_system_id)->update(['price' => $price]);
            }
            DB::commit();
            return $this->successMessage('Updated Successfully');
        }
        catch (\Exception $exception){
            DB::rollBack();
            return $this->errorMessage($exception->getMessage());
        }
    }


    public function delete($id){
        $invoice =  Invoice::find($id);
        if (!$invoice){
            abort(404);
        }
        $invoice->delete();

        return $this->successMessage('Deleted Successfully');
    }

    public function changeStatus($id){
        $invoice =  Invoice::find($id);
        if (!$invoice){
            abort(404);
        }

        $invoice->is_close = !$invoice->is_close;
        $invoice->save();
        return $this->successMessage('Status Changed Successfully');
    }


    //for export to pdf and Excel file
    public function export(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new \App\Exports\PDF\InvoiceExport(), 'company.xlsx');
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new \App\Exports\PDF\InvoiceExport(), 'company.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }
}
