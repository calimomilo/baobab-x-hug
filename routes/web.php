<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollectController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\KPIController;
use App\Http\Controllers\SeasonController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth/login', 'showLogin')->name('login');
    Route::post('/auth/login', 'login')->middleware([HandlePrecognitiveRequests::class]);
});

Route::get('/contact', [ContactFormController::class, 'create'])->name('contact');
Route::post('/contact', [ContactFormController::class, 'store'])->middleware([HandlePrecognitiveRequests::class]);

Route::middleware('auth')->group(function () {

    Route::get('/admin', function () {
        return to_route('dashboard');
    });

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [DisplayController::class, 'displayAdmin'])->name('dashboard');

        Route::resource('companies', CompanyController::class)->middleware([HandlePrecognitiveRequests::class]);

        Route::resource('contacts', ContactFormController::class)->only(['index', 'destroy']);

        Route::resource('collects', CollectController::class)->middleware([HandlePrecognitiveRequests::class]);
        Route::put('/collects/{id}/complete', [CollectController::class, 'complete']);
        Route::put('/collects/{id}/incomplete', [CollectController::class, 'incomplete']);

        Route::get('/seasons/open', [SeasonController::class, 'showOpen'])->name('seasons.open');
        Route::post('/seasons/open', [SeasonController::class, 'open']);
        Route::resource('seasons', SeasonController::class)->only(['destroy']);
        Route::get('/seasons/{id}/close', [SeasonController::class, 'showClose'])->name('seasons.close');
        Route::put('/seasons/{id}/close', [SeasonController::class, 'close']);
    });

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});

Route::controller(DisplayController::class)->group(function () {
    Route::get('/', 'displayHome')->name('home');
    Route::get('/leaderboard', 'displayLeaderboard')->name('leaderboard');
    Route::get('/blood-league', 'displayBloodLeague')->name('blood-league');
    Route::get('/don-du-sang', 'displayDonDuSang')->name('don-du-sang');

    Route::get('/{slug}', 'displayHome')->name('home.slug');
    Route::get('/{slug}/leaderboard', 'displayLeaderboard')->name('leaderboard.slug');
    Route::get('/{slug}/blood-league', 'displayBloodLeague')->name('blood-league.slug');
    Route::get('/{slug}/don-du-sang', 'displayDonDuSang')->name('don-du-sang.slug');

    Route::get('/{slug}/don-du-sang#conditions', 'displayDonDuSang')->name('conditions.slug');
    Route::get('/{slug}/checker/{step?}', 'displayChecker')->name('checker');

    Route::get('/{slug}/{id}/donor', 'displayDonor')->name('donor');
    Route::get('/{slug}/{id}/supporter', 'displaySupporter')->name('supporter');
});

Route::controller(KPIController::class)->group(function () {
    Route::post('/{slug}/donor', 'donorResult')->name('donor-result');
    Route::post('/{slug}/supporter', 'supporterResult')->name('supporter-result');
    Route::post('/{slug}/appointment-click', 'appointmentClick')->name('appointment-click');
    Route::post('/{slug}/donor-share', 'donorShare')->name('donor-share');
    Route::post('/{slug}/supporter-share', 'supporterShare')->name('supporter-share');
});

Route::controller(DownloadController::class)->prefix('download')->group(function () {
    Route::get('/kits/donor', 'downloadDonorKit')->name('download.donor');
    Route::get('/kits/supporter', 'downloadSupporterKit')->name('download.supporter');
});
