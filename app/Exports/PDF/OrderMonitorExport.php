<?php

namespace App\Exports\PDF;

use App\Models\DateWiseMonitor;
use App\Models\Hall;
use App\Trait\PDFExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class OrderMonitorExport implements FromView
{
    use PDFExportTrait;
    public function __construct()
    {
        $this->handle_size = 2;
        $this->headings = 'db.order_monitoring';
        $columns = array_keys(__('db.order_monitoring'));
        $this->setValidColumns($columns);
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $data = DateWiseMonitor::filter()->get();
        $columns = $this->valid_column;
        $headings = $this->headings;
        $per_cell =  $this->perCell();
        return view('exports.order_monitoring', compact('data','columns', 'per_cell', 'headings'));
    }


}
