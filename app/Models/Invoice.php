<?php

namespace App\Models;

use App\Model;
use App\Observers\InvoiceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([InvoiceObserver::class])]
class Invoice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeFilter(Builder $builder){
        $builder->with(['order', 'invoice_data']);
    }


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id')->with(['hotel', 'hall']);
    }
    public function invoice_data()
    {
        return $this->hasMany(InvoiceData::class, 'invoice_id', 'id');
    }

    public function getTotalPriceAttribute()
    {
        return $this->invoice_data->sum('total_price');
    }

    public function getTotalPriceAfterDiscountAttribute()
    {
        return $this->getTotalPriceAttribute() - $this->discount;
    }

    public function getTaxAmountAttribute()
    {
        return ($this->getTotalPriceAfterDiscountAttribute() * $this->tax) /100;
    }

    public function getTotalWithTaxAttribute()
    {
        return $this->getTaxAmountAttribute() + $this->getTotalPriceAfterDiscountAttribute();
    }

    public static function GenerateInvoiceNumber(){
        $model = Invoice::orderBy('id', 'desc')->first();
        $number = "1";
        if ($model){
            $number = $model->id+1;
        }

        return str_pad($number,4,"0",STR_PAD_LEFT );

    }
}
