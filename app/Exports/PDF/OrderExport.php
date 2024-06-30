<?php

namespace App\Exports\PDF;

use App\Models\Order;
use App\Trait\PDFExportTrait;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView
{
    use PDFExportTrait;
    public function __construct()
    {
        $this->title = __('page.order_list');
        $this->handle_size = 2;
        $this->headings = 'db.order';
        $columns = (new Order())->getColumns();
        $this->setValidColumns($columns);
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $data = Order::filter()->get();
        $columns = $this->valid_column;
        $headings = $this->headings;
        $per_cell =  $this->perCell();
        $title = $this->title;
        return view('exports.order', compact('title','data','columns', 'per_cell', 'headings'));
    }
}
