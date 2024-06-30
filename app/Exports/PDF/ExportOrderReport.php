<?php

namespace App\Exports\PDF;

use App\Models\Order;
use App\Trait\PDFExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ExportOrderReport implements FromView
{
    use PDFExportTrait;
    public function __construct()
    {
        $this->title = __('page.list_of_order_report');
        $this->handle_size = 1;
        $this->headings = 'db.report.order';
        $columns = array_keys(__('db.report.order'));;
        $this->setValidColumns($columns);
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $data = Order::ReportFilter()->get();
        $columns = $this->valid_column;
        $headings = $this->headings;
        $per_cell =  $this->perCell();
        $title = $this->title;
        return view('exports.reports.order', compact('title','data','columns', 'per_cell', 'headings'));
    }
}
