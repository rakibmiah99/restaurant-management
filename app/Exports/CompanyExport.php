<?php

namespace App\Exports;

use App\Models\Company;
use App\Trait\ExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;

class CompanyExport implements FromCollection, WithHeadings, WithColumnWidths, ShouldAutoSize, WithStyles, WithEvents
{
    use ExportTrait;
    public function __construct()
    {
        $columns = (new Company())->getColumns();
        $this->headings = 'db.company';
        $this->setValidColumn($columns);
        $this->title = 'Company List';
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Company::filter()->get($this->valid_column);
    }


}
