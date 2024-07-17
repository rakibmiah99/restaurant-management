<?php

namespace App\Providers;

use App\Models\Hotel;
use App\Services\CompanyService;
use App\Services\HallService;
use App\Services\HotelService;
use App\Services\MealPriceService;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class DependencyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CompanyService::class, function (Application $app){
            $request = $app->make(Request::class);
            $company_id = $request->route('id');
            return new CompanyService($company_id);
        });

        $this->app->singleton(MealPriceService::class, function (Application $app){
            $request = $app->make(Request::class);
            $company_id = $request->route('id');
            return new MealPriceService($company_id);
        });

        $this->app->singleton(HotelService::class, function (Application $app){
            $request = $app->make(Request::class);
            $company_id = $request->route('id');
            return new HotelService($company_id);
        });

        $this->app->singleton(HallService::class, function (Application $app){
            $request = $app->make(Request::class);
            $company_id = $request->route('id');
            return new HallService($company_id);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
