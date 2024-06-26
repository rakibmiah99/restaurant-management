<?php

namespace App\Models;

use App\Enums\Status;
use App\Model;
use App\Models\Scopes\DescScope;
use App\Observers\InvoiceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([InvoiceObserver::class]), ScopedBy(DescScope::class)]
class Invoice extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeFilter(Builder $builder){
        $request = request();
        $builder->with(['order', 'invoice_data']);
        if ($q = trim($request->q)) {
            foreach (array_keys(__('db.invoice')) as $column){
                if ($column == 'order_number'){
                    $builder->orWhereRelation('order', 'order_number', 'LIKE', "%{$q}%");
                }
                else if ($column == 'hotel_id'){
                    $builder->orWhereRelation('order.hotel', 'name', 'LIKE', "%{$q}%");
                }
                else if ($column == 'hall_id'){
                    $builder->orWhereRelation('order.hall', 'name', 'LIKE', "%{$q}%");
                }
                else if ($column == 'invoice_number'){
                    $builder->orWhere('invoice_number', 'LIKE', "%{$q}%");
                }
                else if ($column == 'invoice_date'){
                    $builder->orWhereDate('invoice_date', $q);
                }
            }
        }
    }

    public function scopeReportFilter(Builder $builder){
        $request = request();
        $builder->with(['order', 'invoice_data']);
        if ($request->from_date && $request->to_date) {
            $builder->whereBetween('invoice_date', [$request->from_date, $request->to_date]);
        }
        if ($request->hotel){
            $builder->whereRelation('order', 'hotel_id', $request->hotel);
        }
        if ($request->company){
            $builder->whereRelation('order', 'company_id', $request->hotel);
        }
        if ($request->company){
            $builder->whereRelation('order', 'service_type', $request->service_type);
        }
    }


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id')->with(['hotel', 'hall', 'country', 'company']);
    }
    public function invoice_data()
    {
        return $this->hasMany(InvoiceData::class, 'invoice_id', 'id');
    }


    public function getMealSystemNamesAttribute(){
        $meal_systems_id =  $this->invoice_data->pluck('meal_system_id')->unique();
        $meal_systems = MealSystem::whereIn('id', $meal_systems_id)->pluck('name')->toArray();
        return implode(', ',$meal_systems);
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
