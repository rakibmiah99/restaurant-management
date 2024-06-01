<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth.check', 'localization'])->prefix('/')->group(function (){
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'page'])->name('home');

    Route::prefix('company')->name('company.')->group(function (){
        Route::get('/', [\App\Http\Controllers\CompanyController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\CompanyController::class, 'create'])->name('create');
        Route::get('/show/{id}', [\App\Http\Controllers\CompanyController::class, 'show'])->name('show');
        Route::get('/changeStatus/{id}', [\App\Http\Controllers\CompanyController::class, 'changeStatus'])->name('changeStatus');
        Route::post('/store', [\App\Http\Controllers\CompanyController::class, 'store'])->name('store');
        Route::post('/delete/{id}', [\App\Http\Controllers\CompanyController::class, 'delete'])->name('delete');
        Route::get('/export', [\App\Http\Controllers\CompanyController::class, 'export'])->name('export');
    });



    Route::get('change-lang/{lang}', [\App\Http\Controllers\LangController::class, 'change'])->name('lang.change');
});




Route::get('/login', [\App\Http\Controllers\AuthController::class, 'loginPage'])->name('loginPage');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
