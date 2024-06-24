<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public static function GenerateInvoiceNumber(){
        $model = Invoice::orderBy('id', 'desc')->first();
        $number = "1";
        if ($model){
            $number = $model->id+1;
        }

        return str_pad($number,4,"0",STR_PAD_LEFT );

    }
}
