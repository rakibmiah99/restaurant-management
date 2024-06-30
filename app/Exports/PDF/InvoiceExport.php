<?php

namespace App\Exports\PDF;

use App\Models\Company;
use App\Models\Invoice;
use App\Trait\PDFExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceExport implements FromView
{
    use PDFExportTrait;
    public function __construct()
    {
        $this->title = __('page.invoice_list');
        $this->handle_size = 1;
        $this->headings = 'db.invoice';
        $columns = array_keys(__('db.invoice'));
        $this->setValidColumns($columns);
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $data = Invoice::filter()->get();
        $columns = $this->valid_column;
        $headings = $this->headings;
        $per_cell =  $this->perCell();
        $title = $this->title;
        return view('exports.invoice', compact('title','data','columns', 'per_cell', 'headings'));
    }
}
