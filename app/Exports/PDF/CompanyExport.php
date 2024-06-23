<?php

namespace App\Exports\PDF;

use App\Models\Company;
use App\Models\OrderMonitoring;
use App\Trait\PDFExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CompanyExport implements FromView
{
    use PDFExportTrait;
    public function __construct()
    {
        $this->headings = 'db.company';
        $columns = (new Company())->getColumns();
        $this->setValidColumns($columns);
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $data = Company::filter()->get($this->valid_column);
        $columns = $this->valid_column;
        $headings = $this->headings;
        $per_cell =  $this->perCell();
        return view('exports.company', compact('data','columns', 'per_cell', 'headings'));
    }
}
