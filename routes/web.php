<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth.check')->prefix('/')->group(function (){
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'page'])->name('home');
    Route::get('/company', [\App\Http\Controllers\CompanyController::class, 'index'])->name('company');
    Route::get('/company/create', [\App\Http\Controllers\CompanyController::class, 'create'])->name('company.create');
    Route::get('/company/show/{id}', [\App\Http\Controllers\CompanyController::class, 'show'])->name('company.show');
    Route::get('/company/changeStatus/{id}', [\App\Http\Controllers\CompanyController::class, 'changeStatus'])->name('company.changeStatus');
    Route::post('/company/store', [\App\Http\Controllers\CompanyController::class, 'store'])->name('company.store');
    Route::post('/company/delete/{id}', [\App\Http\Controllers\CompanyController::class, 'delete'])->name('company.delete');
});




Route::get('/login', [\App\Http\Controllers\AuthController::class, 'loginPage'])->name('loginPage');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
