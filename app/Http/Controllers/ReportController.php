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
