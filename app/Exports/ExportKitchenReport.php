<?php

namespace App\Exports;

use App\Models\OrderMonitoring;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportKitchenReport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public array $valid_column = [];
    public function __construct()
    {
        $columns = array_keys(__('db.report.kitchen'));
        foreach (request()->columns ?? $columns as $column){
            if (in_array($column, $columns)){
                $this->valid_column [] = $column;
            }
        }

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return OrderMonitoring::KitchenQuery()->get();
    }

    public function headings(): array
    {
        return array_map(function($column){
            return __('db.report.kitchen.'.$column);
        },$this->valid_column);
    }

    public function styles(Worksheet $sheet)
    {
        //https://docs.laravel-excel.com/3.1/exports/column-formatting.html#styling
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
