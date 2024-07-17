<?php

namespace App;

use App\Models\Company;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends \Illuminate\Database\Eloquent\Model
{
    public function getColumns($final_exclude = []): array
    {
        $columns =  $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $exclude = [
            'id',
            'created_by',
            'updated_by',
            'deleted_at',
            'created_at',
            'updated_at'
        ];
        $selectedColumns = array_diff($columns, $exclude);
        $selectedColumns = array_merge($selectedColumns, $this->attributes_as_column ?? []);
        return $selectedColumns = array_diff($selectedColumns, $final_exclude);
    }
}
