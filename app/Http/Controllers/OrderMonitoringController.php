<?php

namespace App\Http\Controllers;

use App\Enums\ExportFormat;
use App\Exports\OrderExport;
use App\Exports\OrderMonitorExport;
use App\Helper;
use App\Models\Country;
use App\Models\DateWiseMonitor;
use App\Models\Hall;
use App\Models\Hotel;
use App\Models\MealSystem;
use App\Models\OrderMonitoring;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderMonitoringController extends Controller
{
    public function index(Request $request)
    {
        $columns = array_keys(__('db.order_monitoring'));
        $hotels = Hotel::get();
        $countries = Country::get();
        $meal_systems = MealSystem::get();
        $halls = request()->get('hotel') ? Hall::where('hotel_id', request()->get('hotel') )->get() : [];
        $data =  DateWiseMonitor::InputFilter()->filter()->paginate(Helper::PerPage())->withQueryString();
        return view('order_monitoring.index', compact('data', 'columns', 'hotels', 'countries', 'meal_systems', 'halls'));
    }

    public function export(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new OrderMonitorExport(), Helper::GenerateFileName('order_monitor', ExportFormat::XLSX->value));
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new OrderMonitorExport(), Helper::GenerateFileName('order_monitor', ExportFormat::PDF->value), \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }
}
