<?php

namespace App\Exports\PDF;

use App\Models\Company;
use App\Models\MealPrice;
use App\Trait\PDFExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class MealPriceExport implements FromView
{
    use PDFExportTrait;
    public function __construct()
    {
        $this->title = __('page.meal_price_list');
        $this->headings = 'db.meal_price';
        $columns = (new MealPrice())->getColumns();
        $this->setValidColumns($columns);
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $data = MealPrice::filter()->get($this->valid_column);
        $columns = $this->valid_column;
        $headings = $this->headings;
        $per_cell =  $this->perCell();
        $title = $this->title;
        return view('exports.meal_price', compact('data','title','columns', 'per_cell', 'headings'));
    }
}
