<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportHotelReport implements FromCollection, WithHeadings, WithMapping
{
    public array $valid_column = [];
    public function __construct()
    {
        $columns = array_keys(__('db.report.hotel'));
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
        return Order::ReportFilter()->get();
    }

    public function map($model): array
    {
        $data = [];

        foreach ($this->valid_column as $column){
            if($column == "order_number")
                $data[$column] = $model->order_number;
            elseif($column == "order_date")
                $data[$column] = $model->order_date;
            elseif($column == "hotel")
                $data[$column] = $model->hotel?->name;
            elseif($column == "hall")
                $data[$column] = $model->hall?->name;
            elseif($column == "cuisine_name")
                $data[$column] = $model->country?->name;
            elseif($column == "meal_system")
                $data[$column] = $model->meal_system_names;
            elseif($column == "service_type")
                $data[$column] = $model->$column;
            elseif($column == "company")
                $data[$column] = $model->company?->name;
            elseif($column == "breakfast")
                $data[$column] = $model->total_break_fast;
            elseif($column == "lunch")
                $data[$column] = $model->total_lunch;
            elseif($column == "dinner")
                $data[$column] = $model->total_dinner;
            elseif($column == "seheri")
                $data[$column] = $model->total_seheri;
            elseif($column == "iftar")
                $data[$column] = $model->total_iftar;
            elseif($column == "total_meal")
                $data[$column] = $model->total_meal;


        }

        return $data;

    }

    public function headings(): array
    {
        return array_map(function($column){
            return __('db.report.hotel.'.$column);
        },$this->valid_column);
    }
}
