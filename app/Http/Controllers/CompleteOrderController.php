<?php

namespace App\Http\Controllers;

use App\Enums\ExportFormat;
use App\Helper;
use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CompleteOrderController extends Controller
{
    public function index(){
        $orders =  Order::CompleteOrderFilter()->with(['hotel', 'hall', 'meal_systems', 'country', 'order_monitoring'])->get()->where('is_complete', true);
        $data = Helper::Paginate($orders, Helper::PerPage())->withQueryString();
        $columns = array_keys(__('db.complete_order'));
        return view('order.complete_order', compact('data', 'columns'));
    }

    public function export(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new \App\Exports\PDF\CompleteOrderExport(), Helper::GenerateFileName('complete_orders', ExportFormat::XLSX->value));
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new \App\Exports\PDF\CompleteOrderExport(), Helper::GenerateFileName('complete_orders', ExportFormat::PDF->value), \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }
}
