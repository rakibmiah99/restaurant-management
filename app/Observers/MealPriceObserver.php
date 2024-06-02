<?php

namespace App\Observers;

use App\Models\MealPrice;
use Illuminate\Support\Facades\Auth;

class MealPriceObserver
{
    /**
     * Handle the MealPrice "creating" event.
     */
    public function creating(MealPrice $mealPrice): void
    {
        $mealPrice->created_by = Auth::id();
    }

    /**
     * Handle the MealPrice "created" event.
     */
    public function created(MealPrice $mealPrice): void
    {
        //
    }

    /**
     * Handle the MealPrice "updated" event.
     */
    public function updated(MealPrice $mealPrice): void
    {
        $mealPrice->updated_by = Auth::id();
    }

    /**
     * Handle the MealPrice "deleted" event.
     */
    public function deleted(MealPrice $mealPrice): void
    {
        //
    }

    /**
     * Handle the MealPrice "restored" event.
     */
    public function restored(MealPrice $mealPrice): void
    {
        //
    }

    /**
     * Handle the MealPrice "force deleted" event.
     */
    public function forceDeleted(MealPrice $mealPrice): void
    {
        //
    }
}
