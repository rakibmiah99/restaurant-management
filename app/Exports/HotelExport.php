<?php

namespace App\Exports;

use App\Enums\ExportFormat;
use App\Models\Hotel;
use App\Trait\ExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class HotelExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnWidths, WithStyles, WithEvents
{

    use ExportTrait;
    public function __construct()
    {
        $columns = (new Hotel())->getColumns();
        $this->headings = 'db.hotel';
        $this->setValidColumn($columns);
        $this->title = 'Hotel List';
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Hotel::filter()->get($this->valid_column);
    }
    
}
