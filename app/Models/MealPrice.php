<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealPrice extends Model
{
    use HasFactory;

    function ScopeActive(Builder $builder){
        $builder->where('status', true);
    }
}
