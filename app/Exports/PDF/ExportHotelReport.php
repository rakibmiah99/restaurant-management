<?php

namespace App\Exports\PDF;

use App\Models\Order;
use App\Models\OrderMonitoring;
use App\Trait\PDFExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;

class ExportHotelReport implements FromView
{
    use PDFExportTrait;
    public function __construct()
    {
        $this->handle_size = 2;
        $this->headings = 'db.report.hotel';
        $columns = array_keys(__('db.report.hotel'));;
        $this->setValidColumns($columns);
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $data = Order::ReportFilter()->get();
        $columns = $this->valid_column;
        $headings = $this->headings;
        $per_cell =  $this->perCell();
        return view('exports.reports.hotel', compact('data','columns', 'per_cell', 'headings'));
    }
}
