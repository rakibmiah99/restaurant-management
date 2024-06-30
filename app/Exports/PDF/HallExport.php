<?php

namespace App\Exports\PDF;

use App\Models\Company;
use App\Models\Hall;
use App\Trait\PDFExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class HallExport implements FromView
{
    use PDFExportTrait;
    public function __construct()
    {
        $this->title = __('page.hall_list');
        $this->handle_size = 2;
        $this->headings = 'db.hall';
        $columns = (new Hall())->getColumns();
        $this->setValidColumns($columns);
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $data = Hall::filter()->get($this->valid_column);
        $columns = $this->valid_column;
        $headings = $this->headings;
        $per_cell =  $this->perCell();
        $title = $this->title;
        return view('exports.hall', compact('title','data','columns', 'per_cell', 'headings'));
    }
}
