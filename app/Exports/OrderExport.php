<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    public array $valid_column = [];
    public function __construct()
    {
        $table_columns = (new Order())->getColumns();
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
        return Order::all();
    }

    public function map($model): array
    {
        $data = [];
        foreach ($this->valid_column as $column){
            if($column == "status"){
                $data[$column] = $model->$column ? \App\Enums\Status::ACTIVE->value : \App\Enums\Status::INACTIVE->value;
            }
            elseif($column == "hall_id"){
                $data[$column] = $model->hall?->name;
            }

            elseif($column == "company_id"){
                $data[$column] = $model->company?->name;
            }
            elseif($column == "hotel_id"){
                $data[$column] = $model->hotel?->name;
            }

            elseif($column == "country_id"){
                $data[$column] = $model->country?->name;
            }

            elseif($column == "mpi_for_normal"){
                $data[$column] = $model->meal_price_for_normal?->name;
            }

            elseif($column == "mpi_for_ramadan"){
                $data[$column] = $model->meal_price_for_ramadan?->name;
            }

            else{
                $data[$column] = $model->$column;
            }

        }

        return $data;

    }

    public function headings(): array
    {
        return array_map(function($column){
            return __('db.order.'.$column);
        },$this->valid_column);
    }
}
