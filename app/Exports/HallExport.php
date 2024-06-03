<?php

namespace App\Exports;

use App\Models\Hall;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HallExport implements FromCollection, WithHeadings
{
    public array $valid_column = [];
    public function __construct()
    {
        $table_columns = (new Hall())->getColumns();
        foreach (request()->columns ?? $table_columns as $column){
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
        return Hall::filter()->get($this->valid_column);
    }

    public function headings(): array
    {
        return array_map(function($column){
            return __('db.hall.'.$column);
        },$this->valid_column);
    }
}
