<?php

namespace App\Trait;

trait PDFExportTrait
{
    public array $valid_column = [];
    public string $headings;
    public string $title;
    public int $handle_size = 0;
    public function setValidColumns($columns)
    {
        foreach (request()->columns ?? $columns as $column){
            if (in_array($column, $columns)){
                $this->valid_column [] = $column;
            }
        }
    }

    public function perCell()
    {
        $number_of_columns = count($this->valid_column);
        $per_cell = 95 / $number_of_columns+1;
        return $per_cell - $this->handle_size;
    }
}
