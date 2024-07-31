<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Dompdf\Dompdf;
class DompdfServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Dompdf::class, function ($app) {
            $dompdf = new Dompdf();
            $dompdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'Tajawal-Regular', // Name of the font
            ]);
            $dompdf->getOptions()->set('isFontSubsettingEnabled', true);
            $dompdf->getOptions()->set('fontCache', storage_path('assets/fonts'));

            return $dompdf;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
