<?php

namespace App\Http\Controllers;

use App\Enums\ExportFormat;
use App\Helper;
use App\Models\Company;
use App\Models\Country;
use App\Models\Hall;
use App\Models\Hotel;
use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderReportController extends Controller
{
    public function index()
    {
        $columns = array_keys(__('db.report.order'));
        $hotels = Hotel::get();
        $countries = Country::get();
        $companies = Company::get();
//        return Order::latest()->first()->order_monitoring->unique('meal_date')->count();
        $halls = request()->get('hotel') ? Hall::where('hotel_id', request()->get('hotel') )->get() : [];
        $data = Order::ReportFilter()->paginate(Helper::PerPage())->withQueryString();
        return view('reports.order.index', compact('columns', 'data', 'hotels', 'countries', 'companies', 'halls'));
    }

    public function export(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new \App\Exports\PDF\ExportOrderReport(), Helper::GenerateFileName('order_report', ExportFormat::XLSX->value));
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new \App\Exports\PDF\ExportOrderReport(), Helper::GenerateFileName('order_report', ExportFormat::PDF->value), \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }

    public function show($order_id)
    {
        $columns = array_keys(__('db.report.hall'));
        $order = Order::find($order_id);
        return view('reports.hall.show', compact('columns', 'order'));
    }
}
