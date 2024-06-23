<?php

namespace App\Exports\PDF;

use App\Models\OrderMonitoring;
use App\Trait\PDFExportTrait;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportKitchenReport implements  FromView, ShouldAutoSize
{
    use PDFExportTrait;
    public function __construct()
    {
        $this->headings = 'db.report.kitchen';
        $columns = array_keys(__('db.report.kitchen'));;
        $this->setValidColumns($columns);
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $data = OrderMonitoring::KitchenQuery()->get();
        $columns = $this->valid_column;
        $headings = $this->headings;
        $per_cell =  $this->perCell();
        return view('exports.reports.kitchen', compact('data','columns', 'per_cell', 'headings'));
    }
}
