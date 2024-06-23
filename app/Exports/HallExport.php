<?php

namespace App\Exports;

use App\Models\Hall;
use App\Trait\ExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class HallExport implements FromCollection, WithHeadings, WithColumnWidths, ShouldAutoSize, WithStyles, WithEvents
{
    use ExportTrait;
    public function __construct()
    {
        $columns = (new Hall())->getColumns();
        $this->headings = 'db.hall';
        $this->setValidColumn($columns);
        $this->title = 'Company List';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Hall::filter()->get($this->valid_column);
    }
}
