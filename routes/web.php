<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth.check', 'localization'])->prefix('/')->group(function (){
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'page'])->name('home');

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
        Route::get('/choose', [\App\Http\Controllers\OrderController::class, 'choose'])->name('choose');
        Route::get('/choose', [\App\Http\Controllers\OrderController::class, 'choose'])->name('choose');
        Route::get('/create', [\App\Http\Controllers\OrderController::class, 'create'])->name('create');
        Route::get('/show/{id}', [\App\Http\Controllers\OrderController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [\App\Http\Controllers\OrderController::class, 'edit'])->name('edit');
        Route::get('/changeStatus/{id}', [\App\Http\Controllers\OrderController::class, 'changeStatus'])->name('changeStatus');
        Route::post('/update/{id}', [\App\Http\Controllers\OrderController::class, 'update'])->name('update');
        Route::post('/store', [\App\Http\Controllers\OrderController::class, 'store'])->name('store');
        Route::post('/delete/{id}', [\App\Http\Controllers\OrderController::class, 'delete'])->name('delete');
        Route::get('/export', [\App\Http\Controllers\OrderController::class, 'export'])->name('export');
    });


    Route::get('meal-systems-by-meal-price', [\App\Http\Controllers\MealPriceController::class, 'mealSystemByMealPrice'])->name('meal-system-by-meal-price');
    Route::get('change-lang/{lang}', [\App\Http\Controllers\LangController::class, 'change'])->name('lang.change');
});




Route::get('/login', [\App\Http\Controllers\AuthController::class, 'loginPage'])->name('loginPage');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
