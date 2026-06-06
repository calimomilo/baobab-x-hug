<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollectController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\SeasonController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;

// Route::inertia('/', 'Welcome')->name('home');

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/login', 'showLogin')->name('login');
    Route::post('/auth/login', 'login');
});

Route::controller(DisplayController::class)->group(function () {
    Route::get('/', 'displayHome')->name('home');
    Route::get('/leaderboard', 'displayLeaderboard')->name('leaderboard');
    Route::get('/blood-league', 'displayBloodLeague')->name('blood-league');
    Route::get('/don-du-sang', 'displayDonDuSang')->name('don-du-sang');
});

Route::get('/contact', [ContactFormController::class, 'create'])->name('contact');
Route::post('/contact', [ContactFormController::class, 'store'])->middleware([HandlePrecognitiveRequests::class]);

Route::middleware('auth')->group(function () {
    Route::resource('companies', CompanyController::class);

    Route::resource('contacts', ContactFormController::class)->only(['index', 'show', 'destroy']);

    Route::resource('collects', CollectController::class);
    Route::put('/collects/{id}/complete', [CollectController::class, 'complete']);
    Route::put('/collects/{id}/incomplete', [CollectController::class, 'incomplete']);

    Route::get('/seasons/open', [SeasonController::class, 'showOpen']);
    Route::post('/seasons/open', [SeasonController::class, 'open']);
    Route::resource('seasons', SeasonController::class)->only(['show', 'edit', 'update', 'destroy']);
    Route::get('/seasons/{id}/close', [SeasonController::class, 'showClose']);
    Route::put('/seasons/{id}/close', [SeasonController::class, 'close']);

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});
