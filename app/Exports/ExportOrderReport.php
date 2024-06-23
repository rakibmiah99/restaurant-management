<?php

namespace App\Exports;

use App\Enums\ExportFormat;
use App\Models\Order;
use App\Trait\ExportTrait;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class ExportOrderReport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, ShouldAutoSize, WithStyles, WithEvents
{
    use ExportTrait;
    public function __construct($format = ExportFormat::PDF->value)
    {
        $columns = array_keys(__('db.report.order'));
        $this->format = $format;
        $this->headings = 'db.report.order';
        $this->setValidColumn($columns);

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
            elseif($column == "total_of_guest")
                $data[$column] = $model->total_guest;
            elseif($column == "first_meal_date")
                $data[$column] = $model->first_meal_date;
            elseif($column == "last_meal_date")
                $data[$column] = $model->last_meal_date;
            elseif($column == "num_of_days")
                $data[$column] = $model->number_of_days;
        }

        return $data;

    }



}
