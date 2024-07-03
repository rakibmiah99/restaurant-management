<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CustomDirectiveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        Blade::directive('canView', function ($group_name) {
            // Using Laravel's @if directive within the custom directive
            return "<?php if(auth()->check() && auth()->user()->can($group_name.'.actions.view')): ?>";
        });

        Blade::directive('endCanView', function () {
            return "<?php endif; ?>";
        });


        Blade::directive('canCreate', function ($group_name) {
            // Using Laravel's @if directive within the custom directive
            return "<?php if(auth()->check() && auth()->user()->can($group_name.'.actions.create')): ?>";
        });

        Blade::directive('endCanCreate', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('canUpdate', function ($group_name) {
            // Using Laravel's @if directive within the custom directive
            return "<?php if(auth()->check() && auth()->user()->can($group_name.'.actions.update')): ?>";
        });

        Blade::directive('endCanUpdate', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('canDelete', function ($group_name) {
            // Using Laravel's @if directive within the custom directive
            return "<?php if(auth()->check() && auth()->user()->can($group_name.'.actions.delete')): ?>";
        });

        Blade::directive('endCanDelete', function () {
            return "<?php endif; ?>";
        });


        Blade::directive('canExport', function ($group_name) {
            // Using Laravel's @if directive within the custom directive
            return "<?php if(auth()->check() && auth()->user()->can($group_name.'.actions.export')): ?>";
        });

        Blade::directive('endCanExport', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('canChangeStatus', function ($group_name) {
            // Using Laravel's @if directive within the custom directive
            return "<?php if(auth()->check() && auth()->user()->can($group_name.'.actions.change_status')): ?>";
        });

        Blade::directive('endCanChangeStatus', function () {
            return "<?php endif; ?>";
        });
    }
}
