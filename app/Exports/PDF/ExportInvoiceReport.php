<?php

namespace App\Exports\PDF;

use App\Models\Invoice;
use App\Models\Order;
use App\Trait\PDFExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ExportInvoiceReport implements FromView
{
    use PDFExportTrait;
    public function __construct()
    {
        $this->title = __('page.list_of_invoice_report');
        $this->handle_size = 1;
        $this->headings = 'db.report.invoice';
        $columns = array_keys(__('db.report.invoice'));;
        $this->setValidColumns($columns);
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $data = Invoice::ReportFilter()->get();
        $columns = $this->valid_column;
        $headings = $this->headings;
        $per_cell =  $this->perCell();
        $title = $this->title;
        return view('exports.reports.invoice', compact('title','data','columns', 'per_cell', 'headings'));
    }
}
