<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CompleteOrderController extends Controller
{
    public function index(){
        $orders =  Order::with(['hotel', 'hall', 'meal_systems', 'country', 'order_monitoring'])->get()->where('is_complete', true);
        $data = Helper::Paginate($orders, 10)->withQueryString();
//        return Order::latest()->first()->test;
        $columns = array_keys(__('db.complete_order'));
//        $data = Order::filter()->paginate($request->perpage ?? 10)->withQueryString();
        return view('order.complete_order', compact('data', 'columns'));
    }

    public function export(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new \App\Exports\PDF\CompleteOrderExport(), 'orders.xlsx');
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new \App\Exports\PDF\CompleteOrderExport(), 'orders.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }
}
