<?php

namespace App\Observers;

use App\Models\Hall;
use Illuminate\Support\Facades\Auth;

class HallObserver
{
    /**
     * Handle the Hall "creating" event.
     */
    public function creating(Hall $hall): void
    {
        if(auth()->check()){
            $hall->created_by = Auth::id();
        }
    }
    /**
     * Handle the Hall "created" event.
     */
    public function created(Hall $hall): void
    {
        //
    }

    /**
     * Handle the Hall "updated" event.
     */
    public function updated(Hall $hall): void
    {
        $hall->created_by = Auth::id();
    }

    /**
     * Handle the Hall "deleted" event.
     */
    public function deleted(Hall $hall): void
    {
        //
    }

    /**
     * Handle the Hall "restored" event.
     */
    public function restored(Hall $hall): void
    {
        //
    }

    /**
     * Handle the Hall "force deleted" event.
     */
    public function forceDeleted(Hall $hall): void
    {
        //
    }
}
