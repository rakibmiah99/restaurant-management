<?php

namespace App\Trait;

use App\Enums\ExportFormat;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

trait ExportTrait
{
    public array $valid_column = [];
    public string $format;
    public string $headings;
    public string $title = 'demo_title';
    public array $sheet_columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N','O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

    public function headings(): array
    {
        $heading_column = array_map(function($column){
            return __($this->headings.'.'.$column);
        },$this->valid_column);

        if (request()->get('export-type') == "pdf") {
            return [
                [$this->title],
                [date('d M, Y h:i:s A')],
                [auth()->user()->name],
                ['*********************************************'],
                $heading_column
            ];
        }
        else{
            return [
                [$this->title],
                $heading_column
            ];
        }


    }

    public function setValidColumn($columns)
    {
        foreach (request()->columns ?? $columns as $column){
            if (in_array($column, $columns)){
                $this->valid_column [] = $column;
            }
        }
    }

    public function columnWidths(): array
    {
        if (request()->get('export-type') == "pdf"){
            $number_of_columns = count($this->valid_column);
            $per_cell = 100 / $number_of_columns;
            $columns = [];
            for ($i = 0; $i < $number_of_columns; $i++){
                $column_name = $this->sheet_columns[$i];
                $columns[$column_name] = floor($per_cell);
            }

//            dd($columns);
            return $columns;
        }

        else{
            return [];
        }

    }

    public function styles(Worksheet $sheet)
    {
        if (request()->get('export-type') == "pdf"){
            $range = "A1:".$this->sheet_columns[count($this->valid_column)-1]."1";
            $range_row_2 = "A2:".$this->sheet_columns[count($this->valid_column)-1]."2";
            $range_row_3 = "A3:".$this->sheet_columns[count($this->valid_column)-1]."3";
            $range_row_4 = "A4:".$this->sheet_columns[count($this->valid_column)-1]."4";
            $sheet->mergeCells($range);
            $sheet->mergeCells($range_row_2);
            $sheet->mergeCells($range_row_3);
            $sheet->mergeCells($range_row_4);
            //https://docs.laravel-excel.com/3.1/exports/column-formatting.html#styling
            return [
                // Style the first row as bold text.
                1    => [
                    'font' => ['bold' => false, 'size' => 8],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ],

                2 => [
                    'font' => ['bold' => false,'size' => 8],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ],

                3 => [
                    'font' => ['bold' => false,'size' => 8],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ],
                4 => [
                    'font' => ['bold' => false ,'size' => 8],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ],

                'A1:Z500'=> ['font' => ['bold' => true, 'size' => 8]],

            ];
        }
        else{
            $range = "A1:".$this->sheet_columns[count($this->valid_column)-1]."1";
            $sheet->mergeCells($range);
            //https://docs.laravel-excel.com/3.1/exports/column-formatting.html#styling
            return [
                // Style the first row as bold text.
                1    => [
                    'font' => ['bold' => false, 'size' => 12],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ],

                2    => ['font' => ['bold' => true, 'size' => 12]],
            ];
        }


    }


    public function registerEvents(): array
    {
        if (request()->get('export-type') == "pdf"){
            return [
                AfterSheet::class => function(AfterSheet $event) {
                    // Get the underlying PhpSpreadsheet object
                    $sheet = $event->sheet->getDelegate();
                    //remove border
                    $sheet->getStyle('A1:A4')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DASHDOTDOT);
                    // Set the path to your watermark image
                    $imagePath = public_path('assets/logo.png');

                    // Add the watermark image
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $drawing->setName('Watermark');
                    $drawing->setDescription('Watermark');
                    $drawing->setPath($imagePath);


                    $drawing->setWidth(100); // Adjust width as needed
                    $drawing->setWorksheet($sheet);
                },
            ];
        }else{
            return [];
        }

    }
}
