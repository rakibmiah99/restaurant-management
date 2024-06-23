<?php

namespace App\Exports;

use App\Models\MealPrice;
use App\Trait\ExportTrait;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class MealPriceExport implements FromCollection, WithHeadings, WithColumnWidths, ShouldAutoSize, WithStyles, WithEvents
{
    use ExportTrait;
    public array $valid_column = [];
    public function __construct()
    {
        $columns = (new MealPrice())->getColumns();
        $this->headings = 'db.meal_price';
        $this->setValidColumn($columns);
        $this->title = 'Company List';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return MealPrice::filter()->get($this->valid_column);
    }

}
