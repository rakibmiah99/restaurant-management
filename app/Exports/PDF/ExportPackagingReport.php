<?php

namespace App\Exports\PDF;

use App\Models\OrderMonitoring;
use App\Trait\PDFExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ExportPackagingReport implements FromView
{
    use PDFExportTrait;
    public function __construct()
    {
        $this->title = __('page.list_of_packaging_report');
        $this->handle_size = 1;
        $this->headings = 'db.report.packaging';
        $columns = array_keys(__('db.report.packaging'));;
        $this->setValidColumns($columns);
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $data = OrderMonitoring::PackagingQuery()->get();
        $columns = $this->valid_column;
        $headings = $this->headings;
        $per_cell =  $this->perCell();
        $title = $this->title;
        return view('exports.reports.packaging', compact('title','data','columns', 'per_cell', 'headings'));
    }
}
