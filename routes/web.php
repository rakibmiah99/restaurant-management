<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth.check', 'localization'])->prefix('/')->group(function (){
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'page'])->name('home');
    Route::get('/profile', [\App\Http\Controllers\UserController::class, 'profilePage'])->name('profile');
    Route::post('/profile', [\App\Http\Controllers\UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/change-password', [\App\Http\Controllers\UserController::class, 'changePasswordPage'])->name('profile.change_password_page');
    Route::post('/profile/change-password', [\App\Http\Controllers\UserController::class, 'changePassword'])->name('profile.change_password');

    Route::prefix('company')->name('company.')->group(function (){
        Route::get('/', [\App\Http\Controllers\CompanyController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\CompanyController::class, 'create'])->name('create');
        Route::get('/show/{id}', [\App\Http\Controllers\CompanyController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [\App\Http\Controllers\CompanyController::class, 'edit'])->name('edit');
        Route::get('/changeStatus/{id}', [\App\Http\Controllers\CompanyController::class, 'changeStatus'])->name('changeStatus');
        Route::post('/update/{id}', [\App\Http\Controllers\CompanyController::class, 'update'])->name('update');
        Route::post('/store', [\App\Http\Controllers\CompanyController::class, 'store'])->name('store');
        Route::post('/delete/{id}', [\App\Http\Controllers\CompanyController::class, 'delete'])->name('delete');
        Route::get('/export', [\App\Http\Controllers\CompanyController::class, 'export'])->name('export');
    });

    Route::prefix('meal-price')->name('meal_price.')->group(function (){
        Route::get('/', [\App\Http\Controllers\MealPriceController::class, 'index'])->name('index');
        Route::get('/choose', [\App\Http\Controllers\MealPriceController::class, 'choose'])->name('choose');
        Route::get('/create', [\App\Http\Controllers\MealPriceController::class, 'create'])->name('create');
        Route::get('/show/{id}', [\App\Http\Controllers\MealPriceController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [\App\Http\Controllers\MealPriceController::class, 'edit'])->name('edit');
        Route::get('/changeStatus/{id}', [\App\Http\Controllers\MealPriceController::class, 'changeStatus'])->name('changeStatus');
        Route::post('/update/{id}', [\App\Http\Controllers\MealPriceController::class, 'update'])->name('update');
        Route::post('/store', [\App\Http\Controllers\MealPriceController::class, 'store'])->name('store');
        Route::post('/delete/{id}', [\App\Http\Controllers\MealPriceController::class, 'delete'])->name('delete');
        Route::get('/export', [\App\Http\Controllers\MealPriceController::class, 'export'])->name('export');
    });

    Route::prefix('hotel')->name('hotel.')->group(function (){
        Route::get('/', [\App\Http\Controllers\HotelController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\HotelController::class, 'create'])->name('create');
        Route::get('/show/{id}', [\App\Http\Controllers\HotelController::class, 'show'])->name('show');
        Route::get('/halls/{id}', [\App\Http\Controllers\HotelController::class, 'hotelWiseHalls'])->name('getHalls');
        Route::get('/edit/{id}', [\App\Http\Controllers\HotelController::class, 'edit'])->name('edit');
        Route::get('/changeStatus/{id}', [\App\Http\Controllers\HotelController::class, 'changeStatus'])->name('changeStatus');
        Route::post('/update/{id}', [\App\Http\Controllers\HotelController::class, 'update'])->name('update');
        Route::post('/store', [\App\Http\Controllers\HotelController::class, 'store'])->name('store');
        Route::post('/delete/{id}', [\App\Http\Controllers\HotelController::class, 'delete'])->name('delete');
        Route::get('/export', [\App\Http\Controllers\HotelController::class, 'export'])->name('export');
    });


    Route::prefix('hall')->name('hall.')->group(function (){
        Route::get('/', [\App\Http\Controllers\HallController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\HallController::class, 'create'])->name('create');
        Route::get('/show/{id}', [\App\Http\Controllers\HallController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [\App\Http\Controllers\HallController::class, 'edit'])->name('edit');
        Route::get('/changeStatus/{id}', [\App\Http\Controllers\HallController::class, 'changeStatus'])->name('changeStatus');
        Route::post('/update/{id}', [\App\Http\Controllers\HallController::class, 'update'])->name('update');
        Route::post('/store', [\App\Http\Controllers\HallController::class, 'store'])->name('store');
        Route::post('/delete/{id}', [\App\Http\Controllers\HallController::class, 'delete'])->name('delete');
        Route::get('/export', [\App\Http\Controllers\HallController::class, 'export'])->name('export');
    });

    Route::prefix('order')->name('order.')->group(function (){
        Route::get('/', [\App\Http\Controllers\OrderController::class, 'index'])->name('index');
        Route::get('/show-qr/{id}', [\App\Http\Controllers\OrderController::class, 'showQR'])->name('showQR');
        Route::get('/print-qr/{id}', [\App\Http\Controllers\OrderController::class, 'printQR'])->name('printQR');
        Route::get('/show-guest-qr/{code}', [\App\Http\Controllers\OrderController::class, 'showGuestQr'])->name('showGuestQr');
        Route::get('/modify-guest/{id}', [\App\Http\Controllers\OrderController::class, 'modifyGuest'])->name('modify');
        Route::post('/modify-guest/{id}', [\App\Http\Controllers\OrderController::class, 'updateModifyGuest'])->name('modify.save');
        Route::get('/choose', [\App\Http\Controllers\OrderController::class, 'choose'])->name('choose');
        Route::get('/create', [\App\Http\Controllers\OrderController::class, 'create'])->name('create');
        Route::get('/show/{id}', [\App\Http\Controllers\OrderController::class, 'show'])->name('show');
        Route::get('/print-details/{id}', [\App\Http\Controllers\OrderController::class, 'printDetails'])->name('printDetails');
        Route::get('/edit/{id}', [\App\Http\Controllers\OrderController::class, 'edit'])->name('edit');
        Route::get('/changeStatus/{id}', [\App\Http\Controllers\OrderController::class, 'changeStatus'])->name('changeStatus');
        Route::post('/update/{id}', [\App\Http\Controllers\OrderController::class, 'update'])->name('update');
        Route::post('/store', [\App\Http\Controllers\OrderController::class, 'store'])->name('store');
        Route::post('/delete/{id}', [\App\Http\Controllers\OrderController::class, 'delete'])->name('delete');
        Route::get('/export', [\App\Http\Controllers\OrderController::class, 'export'])->name('export');
    });

    Route::prefix('complete-orders')->name('order.')->group(function (){
        Route::get('/', [\App\Http\Controllers\CompleteOrderController::class, 'index'])->name('complete');
        Route::get('/export-complete-order', [\App\Http\Controllers\CompleteOrderController::class, 'export'])->name('export.complete');
    });


    Route::prefix('invoice')->name('invoice.')->group(function (){
        Route::get('/', [\App\Http\Controllers\InvoiceController::class, 'index'])->name('index');
        Route::get('/create/{order_id?}', [\App\Http\Controllers\InvoiceController::class, 'create'])->name('create');
        Route::get('/show/{id}', [\App\Http\Controllers\InvoiceController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [\App\Http\Controllers\InvoiceController::class, 'edit'])->name('edit');
        Route::get('/changeStatus/{id}', [\App\Http\Controllers\InvoiceController::class, 'changeStatus'])->name('changeStatus');
        Route::post('/update/{id}', [\App\Http\Controllers\InvoiceController::class, 'update'])->name('update');
        Route::post('/store', [\App\Http\Controllers\InvoiceController::class, 'store'])->name('store');
        Route::post('/delete/{id}', [\App\Http\Controllers\InvoiceController::class, 'delete'])->name('delete');
        Route::get('/export', [\App\Http\Controllers\InvoiceController::class, 'export'])->name('export');
    });

    Route::prefix('company-settings')->name('settings.')->group(function (){
        Route::get('/', [\App\Http\Controllers\CompanySettingsController::class, 'companySettings'])->name('company');
        Route::post('/update', [\App\Http\Controllers\CompanySettingsController::class, 'companySettingsUpdate'])->name('company.update');
    });



    Route::prefix('order-monitoring')->name('order_monitoring.')->group(function (){
        Route::get('/', [\App\Http\Controllers\OrderMonitoringController::class, 'index'])->name('index');
        Route::get('/export', [\App\Http\Controllers\OrderMonitoringController::class, 'export'])->name('export');
    });
    Route::prefix('report')->name('report.')->group(function (){
        //Hotel Reports
        Route::get('/hotel', [\App\Http\Controllers\HotelReportController::class, 'index'])->name('hotel');
        Route::get('/export-hotel', [\App\Http\Controllers\HotelReportController::class, 'export'])->name('export.hotel');
        Route::get('/hotel/show/{order_id}', [\App\Http\Controllers\HotelReportController::class, 'show'])->name('show.hotel');

        //Hall Reports
        Route::get('/hall', [\App\Http\Controllers\HallReportController::class, 'index'])->name('hall');
        Route::get('/export-hall', [\App\Http\Controllers\HallReportController::class, 'export'])->name('export.hall');
        Route::get('/hall/show/{order_id}', [\App\Http\Controllers\HallReportController::class, 'show'])->name('show.hall');

        //Order Reports
        Route::get('/order', [\App\Http\Controllers\OrderReportController::class, 'index'])->name('order');
        Route::get('/export-order', [\App\Http\Controllers\OrderReportController::class, 'export'])->name('export.order');
        Route::get('/order/show/{order_id}', [\App\Http\Controllers\HotelReportController::class, 'show'])->name('show.order');

        //Invoice Reports
        Route::get('/invoice', [\App\Http\Controllers\InvoiceReportController::class, 'index'])->name('invoice');
        Route::get('/export-invoice', [\App\Http\Controllers\InvoiceReportController::class, 'export'])->name('export.invoice');
        Route::get('/invoice/show/{invoice_id}', [\App\Http\Controllers\InvoiceReportController::class, 'show'])->name('show.invoice');

        //Revenue Reports
        Route::get('/revenue', [\App\Http\Controllers\RevenueReportController::class, 'index'])->name('revenue');
        Route::get('/export-revenue', [\App\Http\Controllers\RevenueReportController::class, 'export'])->name('export.revenue');
        Route::get('/revenue/show/{invoice_id}', [\App\Http\Controllers\RevenueReportController::class, 'show'])->name('show.revenue');


        Route::get('/kitchen', [\App\Http\Controllers\ReportController::class, 'kitchen'])->name('kitchen');
        Route::get('/export-kitchen', [\App\Http\Controllers\ReportController::class, 'export_kitchen'])->name('export.kitchen');


        Route::get('/packaging', [\App\Http\Controllers\ReportController::class, 'packaging'])->name('packaging');
        Route::get('/export-packaging', [\App\Http\Controllers\ReportController::class, 'export_packaging'])->name('export.packaging');

    });


    Route::prefix('roles')->name('role.')->group(function (){
        Route::get('/', [\App\Http\Controllers\RolesController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\RolesController::class, 'create'])->name('create');
        Route::get('/show/{id}', [\App\Http\Controllers\RolesController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [\App\Http\Controllers\RolesController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [\App\Http\Controllers\RolesController::class, 'update'])->name('update');
        Route::post('/store', [\App\Http\Controllers\RolesController::class, 'store'])->name('store');
        Route::post('/delete/{id}', [\App\Http\Controllers\RolesController::class, 'delete'])->name('delete');
    });


    Route::prefix('users')->name('user.')->group(function (){
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\UserController::class, 'create'])->name('create');
        Route::get('/show/{id}', [\App\Http\Controllers\UserController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [\App\Http\Controllers\UserController::class, 'edit'])->name('edit');
        Route::get('/changeStatus/{id}', [\App\Http\Controllers\UserController::class, 'changeStatus'])->name('changeStatus');
        Route::post('/update/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('update');
        Route::post('/store', [\App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::post('/delete/{id}', [\App\Http\Controllers\UserController::class, 'delete'])->name('delete');
        Route::get('/export', [\App\Http\Controllers\UserController::class, 'export'])->name('export');
    });





    Route::get('meal-systems-by-meal-price', [\App\Http\Controllers\MealPriceController::class, 'mealSystemByMealPrice'])->name('meal-system-by-meal-price');
    Route::get('change-lang/{lang}', [\App\Http\Controllers\LangController::class, 'change'])->name('lang.change');
    Route::get('change-theme/{name}', [\App\Http\Controllers\LangController::class, 'changeTheme'])->name('theme.change');
});

Route::get('/taken-meal/{token}',  [\App\Http\Controllers\MealEntryController::class, 'take'])->name('take_meal');

Route::get('/login', [\App\Http\Controllers\AuthController::class, 'loginPage'])->name('loginPage');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');


Route::prefix('copy')->group(function (){
    Route::get('/hotel', [\App\Http\Controllers\CopyController::class, 'hotel']);
    Route::get('/hall', [\App\Http\Controllers\CopyController::class, 'hall']);
    Route::get('/country', [\App\Http\Controllers\CopyController::class, 'country']);
    Route::get('/meal-price', [\App\Http\Controllers\CopyController::class, 'meal_price']);
    Route::get('/company', [\App\Http\Controllers\CopyController::class, 'company']);
});
