<?php

namespace App\Exports;

use App\Models\DateWiseMonitor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderMonitorExport implements WithHeadings, WithMapping, WithChunkReading, FromQuery
{
    public array $valid_column = [];
    public function __construct()
    {
        $columns = array_keys(__('db.order_monitoring'));
        foreach (request()->columns ?? $columns as $column){
            if (in_array($column, $columns)){
                $this->valid_column [] = $column;
            }
        }

    }


    public function query()
    {
        return DateWiseMonitor::filter();
    }

    /**
     * @return \Illuminate\Support\Collection
     */


    public function map($model): array
    {
        $data = [];

        foreach ($this->valid_column as $column){
            if($column == "order_number")
                $data[$column] = $model->order?->order_number;
            elseif($column == 'meal_date')
                $data[$column] = $model->$column;
            elseif($column == "order_date")
                $data[$column] = $model->order?->order_date;
            elseif($column == "hotel")
                $data[$column] = $model->order?->hotel?->name;
            elseif($column == "hall")
                $data[$column] = $model->order?->hall?->name;
            elseif($column == "cuisine_name")
                $data[$column] = $model->order?->country?->name;
            elseif($column == "meal_system_id")
                $data[$column] = $model->meal_system?->name;
            elseif($column == "complete")
                $data[$column] = $model->total_taken;
            elseif($column == "total_meal")
                $data[$column] = $model->total_guest;
            elseif($column == "in_hall")
                $data[$column] = $model->in_hall;
            else{
                $data[$column] = $model->$column;
            }

        }

        return $data;

    }

    public function headings(): array
    {
        return array_map(function($column){
            return __('db.order_monitoring.'.$column);
        },$this->valid_column);
    }

    public function chunkSize(): int
    {
        return 20; // Adjust the chunk size as needed
    }
}
