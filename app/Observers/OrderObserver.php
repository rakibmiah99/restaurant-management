<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderWiseMealPrice;
use Illuminate\Support\Facades\Auth;

class OrderObserver
{
    /**
     * Handle the Order "creating" event.
     */
    public function creating(Order $order): void
    {
        $order->created_by = Auth::id();
    }
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $this->actionToOrderMealPrice($order);
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        $order->updated_by = Auth::id();
        $this->actionToOrderMealPrice($order);
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }

    public function actionToOrderMealPrice($order){
        OrderWiseMealPrice::where('order_id', $order->id)->delete();
        $GLOBALS['orderWiseMealPricesData'] =  [];
        $order->all_meal_price->each(function ($meal_price) use($order){
            $meal_system = $meal_price->meal_system;
            $GLOBALS['orderWiseMealPricesData'] [] = [
                'meal_system_for_meal_price_id' => $meal_price->id,
                'price' => $meal_price->price,
                'meal_system_id' => $meal_system->id,
                'order_id' => $order->id
            ];
        });

        OrderWiseMealPrice::insert($GLOBALS['orderWiseMealPricesData']);
    }
}
