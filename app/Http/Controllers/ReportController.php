<?php

namespace App\Http\Controllers;
use App\Enums\ExportFormat;
use App\Helper;
use App\Models\Company;
use App\Models\Country;
use App\Models\Hall;
use App\Models\Hotel;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderMonitoring;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function hotel()
    {
        $columns = array_keys(__('db.report.hotel'));
        $hotels = Hotel::get();
        $countries = Country::get();
        $companies = Company::get();
        $halls = request()->get('hotel') ? Hall::where('hotel_id', request()->get('hotel') )->get() : [];
        $data = Order::ReportFilter()->paginate(Helper::PerPage())->withQueryString();

        return view('reports.hotel.index', compact('columns', 'data', 'hotels', 'countries', 'companies', 'halls'));
    }

    public function export_hotel(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new \App\Exports\PDF\ExportHotelReport(), Helper::GenerateFileName('hotel_report', ExportFormat::XLSX->value));
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new \App\Exports\PDF\ExportHotelReport(), Helper::GenerateFileName('hotel_report', ExportFormat::XLSX->value), \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }


    public function hall()
    {
        $columns = array_keys(__('db.report.hall'));
        $hotels = Hotel::get();
        $countries = Country::get();
        $companies = Company::get();
        $halls = request()->get('hotel') ? Hall::where('hotel_id', request()->get('hotel') )->get() : [];
        $data = Order::ReportFilter()->paginate(Helper::PerPage())->withQueryString();
        return view('reports.hall.index', compact('columns', 'data', 'hotels', 'countries', 'companies', 'halls'));
    }

    public function export_hall(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new \App\Exports\PDF\ExportHallReport(), Helper::GenerateFileName('hall_report', ExportFormat::XLSX->value));
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new \App\Exports\PDF\ExportHallReport(), Helper::GenerateFileName('hall_report', ExportFormat::PDF->value), \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }

    public function order()
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

    public function export_order(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new \App\Exports\PDF\ExportOrderReport(), Helper::GenerateFileName('order_report', ExportFormat::XLSX->value));
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new \App\Exports\PDF\ExportOrderReport(), Helper::GenerateFileName('order_report', ExportFormat::PDF->value), \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }

    public function invoice()
    {
        $columns = array_keys(__('db.report.invoice'));
        $hotels = Hotel::get();
        $companies = Company::get();
//        return Order::latest()->first()->order_monitoring->unique('meal_date')->count();
        $data = Invoice::ReportFilter()->paginate(Helper::PerPage())->withQueryString();
        return view('reports.invoice.index', compact('columns', 'data', 'hotels', 'companies'));
    }

    public function export_invoice(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new \App\Exports\PDF\ExportInvoiceReport(), Helper::GenerateFileName('invoice_report', ExportFormat::XLSX->value));
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new \App\Exports\PDF\ExportInvoiceReport(), Helper::GenerateFileName('invoice_report', ExportFormat::PDF->value), \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }
    public function revenue()
    {
        $columns = array_keys(__('db.report.revenue'));
        $hotels = Hotel::get();
        $companies = Company::get();
//        return Order::latest()->first()->order_monitoring->unique('meal_date')->count();
        $data = Invoice::ReportFilter()->paginate(Helper::PerPage())->withQueryString();
        return view('reports.revenue.index', compact('columns', 'data', 'hotels', 'companies'));
    }

    public function export_revenue(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new \App\Exports\PDF\ExportRevenueReport(), Helper::GenerateFileName('revenue_report', ExportFormat::XLSX->value));
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new \App\Exports\PDF\ExportRevenueReport(), Helper::GenerateFileName('revenue_report', ExportFormat::PDF->value), \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }


    public function kitchen()
    {
        $data = OrderMonitoring::KitchenQuery()->paginate(Helper::PerPage())->withQueryString();
        $columns = array_keys(__('db.report.kitchen'));
        $countries = Country::get();
        return view('reports.kitchen.index', compact('columns', 'data','countries'));
    }




    public function export_kitchen(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new \App\Exports\PDF\ExportKitchenReport(), Helper::GenerateFileName('kitchen_report', ExportFormat::XLSX->value));
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new \App\Exports\PDF\ExportKitchenReport(), Helper::GenerateFileName('kitchen', ExportFormat::PDF->value), \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }

    public function packaging()
    {
        $data = OrderMonitoring::PackagingQuery()->paginate(Helper::PerPage())->withQueryString();
        $columns = array_keys(__('db.report.packaging'));
        $countries = Country::get();
        $hotels = Hotel::get();
        return view('reports.packaging.index', compact('columns', 'data','countries', 'hotels'));
    }

    public function export_packaging(Request $request){
        if ($request->get('export-type') == "excel"){
            return Excel::download(new \App\Exports\PDF\ExportPackagingReport(), Helper::GenerateFileName('packaging_report', ExportFormat::XLSX->value));
        }
        else if($request->get('export-type') == "pdf"){
            return Excel::download(new \App\Exports\PDF\ExportPackagingReport(), Helper::GenerateFileName('packaging_report', ExportFormat::XLSX->value), \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }
}
