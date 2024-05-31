<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use App\Observers\CompanyObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
#[ObservedBy(CompanyObserver::class)]
class Company extends Model
{
    use HasFactory;

    protected $guarded = [];
    public static function GenerateUniqueID(){
        $company = Company::orderBy('id', 'desc')->first();
        $uniqueID = "1000";
        if ($company){
            $uniqueID = $company->unique_id+1;
        }

        return $uniqueID;
    }
}
