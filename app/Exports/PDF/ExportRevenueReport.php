<?php

namespace App\Exports\PDF;

use App\Models\Invoice;
use App\Trait\PDFExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ExportRevenueReport implements FromView
{
    use PDFExportTrait;
    public function __construct()
    {
        $this->title = __('page.list_of_revenue_report');
        $this->handle_size = 3;
        $this->headings = 'db.report.revenue';
        $columns = array_keys(__('db.report.revenue'));;
        $this->setValidColumns($columns);
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $data = Invoice::ReportFilter()->get();
        $columns = $this->valid_column;
        $headings = $this->headings;
        $per_cell =  $this->perCell();
        $title = $this->title;
        return view('exports.reports.revenue', compact('title','data','columns', 'per_cell', 'headings'));
    }
}
