<?php

namespace App\Observers;

use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;

class HotelObserver
{
    /**
     * Handle the Hotel "creating" event.
     */
    public function creating(Hotel $hotel): void
    {
        $hotel->created_by = Auth::id();
    }

    /**
     * Handle the Hotel "created" event.
     */
    public function created(Hotel $hotel): void
    {

    }

    /**
     * Handle the Hotel "updated" event.
     */
    public function updated(Hotel $hotel): void
    {
        $hotel->updated_by = Auth::id();
    }

    /**
     * Handle the Hotel "deleted" event.
     */
    public function deleted(Hotel $hotel): void
    {
        //
    }

    /**
     * Handle the Hotel "restored" event.
     */
    public function restored(Hotel $hotel): void
    {
        //
    }

    /**
     * Handle the Hotel "force deleted" event.
     */
    public function forceDeleted(Hotel $hotel): void
    {
        //
    }
}
