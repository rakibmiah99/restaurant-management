<?php

namespace App\Exports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompanyExport implements FromCollection, WithHeadings
{
    public array $valid_column = [];
    public function __construct()
    {
        $table_columns = (new Company())->getColumns();
        foreach (request()->columns ?? [] as $column){
            if (in_array($column, $table_columns)){
                $this->valid_column [] = $column;
            }
        }
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Company::filter()->get($this->valid_column);
    }

    public function headings(): array
    {
        return array_map(function($column){
            return __('db.company.'.$column);
        },$this->valid_column);
    }
}
