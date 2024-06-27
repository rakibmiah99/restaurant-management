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
        $this->title = __('page.hotel_list');
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
        $title = $this->title;
        return view('exports.hotel', compact('data','title','columns', 'per_cell', 'headings'));
    }
}
