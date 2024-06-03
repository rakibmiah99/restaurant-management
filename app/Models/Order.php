<?php

namespace App\Models;

use Alkoumi\LaravelHijriDate\Hijri;
use App\Model;
use App\Observers\OrderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeFilter(){

    }

    static function GenerateOrderNumber()
    {
        $order_number = Order::orderBy('id', 'desc')->first()?->order_number;
        $exp = explode('/', $order_number);
        $year = Hijri::Date('Y');
        $sl = 1;
        if(is_array($exp) && count($exp) == 2){
            $sl = $exp[1];
            $sl++;
        }
        $sl =  str_pad($sl,5,"0",STR_PAD_LEFT );
        return $year."/".$sl;
    }
}
