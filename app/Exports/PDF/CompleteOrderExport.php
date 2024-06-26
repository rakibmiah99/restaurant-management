<?php

namespace App\Exports\PDF;

use App\Models\Order;
use App\Trait\PDFExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CompleteOrderExport implements FromView
{
    use PDFExportTrait;
    public function __construct()
    {
        $this->title = __('page.complete_order_list');
        $this->handle_size = 1;
        $this->headings = 'db.complete_order';
        $columns = array_keys(__('db.complete_order'));;
        $this->setValidColumns($columns);
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $data =  Order::CompleteOrderFilter()->with(['hotel', 'hall', 'meal_systems', 'country', 'order_monitoring'])->get()->where('is_complete', true);
        $columns = $this->valid_column;
        $headings = $this->headings;
        $per_cell =  $this->perCell();
        $title = $this->title;
        return view('exports.complete_order', compact('title','data','columns', 'per_cell', 'headings'));
    }
}
