<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth.check')->prefix('/')->group(function (){
    Route::get('/', [\App\Http\Controllers\DashboardController::class, 'page'])->name('home');
    Route::get('/company', [\App\Http\Controllers\CompanyController::class, 'index'])->name('company');
});




Route::get('/login', [\App\Http\Controllers\AuthController::class, 'loginPage'])->name('loginPage');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
