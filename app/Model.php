<?php

namespace App;

use App\Models\Company;
use Barryvdh\Debugbar\Facades\Debugbar;

class Model extends \Illuminate\Database\Eloquent\Model
{

    public function getColumns(): array
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
        return $selectedColumns = array_diff($columns, $exclude);
    }
}
