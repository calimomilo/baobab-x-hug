<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollectController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/login', 'showLogin')->name('login');
    Route::post('/auth/login', 'login');
});

Route::middleware('auth')->group(function () {
    Route::resource('companies', CompanyController::class);

    Route::resource('collects', CollectController::class);
    Route::put('/collects/{id}/complete', [CollectController::class, 'complete']);
    Route::put('/collects/{id}/incomplete', [CollectController::class, 'incomplete']);

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});
