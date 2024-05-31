<?php

namespace App\Observers;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanyObserver
{
    /**
     * Handle the Company "creating" event.
     */
    public function creating(Company $company): void
    {
        $company->created_by = Auth::id();
    }
    /**
     * Handle the Company "created" event.
     */
    public function created(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "updated" event.
     */
    public function updated(Company $company): void
    {
        $company->updated_by = Auth::id();
    }

    /**
     * Handle the Company "deleted" event.
     */
    public function deleted(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "restored" event.
     */
    public function restored(Company $company): void
    {
        //
    }

    /**
     * Handle the Company "force deleted" event.
     */
    public function forceDeleted(Company $company): void
    {
        //
    }
}
