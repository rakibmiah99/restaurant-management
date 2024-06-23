<?php

namespace App\Exports\PDF;

use App\Models\Hall;
use App\Models\Hotel;
use App\Trait\PDFExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class HotelExport implements FromView
{
    use PDFExportTrait;
    public function __construct()
    {
        $this->handle_size = 4;
        $this->headings = 'db.hotel';
        $columns = (new Hotel())->getColumns();
        $this->setValidColumns($columns);
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $data = Hotel::filter()->get($this->valid_column);
        $columns = $this->valid_column;
        $headings = $this->headings;
        $per_cell =  $this->perCell();
        return view('exports.hotel', compact('data','columns', 'per_cell', 'headings'));
    }
}
