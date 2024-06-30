<?php

namespace App\Exports\PDF;

use App\Models\Order;
use App\Trait\PDFExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ExportHallReport implements FromView
{
    use PDFExportTrait;
    public function __construct()
    {
        $this->title = __('page.list_of_hall_report');
        $this->handle_size = 3;
        $this->headings = 'db.report.hall';
        $columns = array_keys(__('db.report.hall'));;
        $this->setValidColumns($columns);
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $data = Order::ReportFilter()->get();
        $columns = $this->valid_column;
        $headings = $this->headings;
        $per_cell =  $this->perCell();
        $title = $this->title;
        return view('exports.reports.hall', compact('title','data','columns', 'per_cell', 'headings'));
    }
}
