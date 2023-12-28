<?php

use App\Http\Controllers\DocumentController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::view('/', 'home')->name('home');
    Route::view('demo', 'demo', ['withoutfooter' => true])->name('demo');

    Route::view('dashboard', 'dashboard')
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');

    require __DIR__ . '/auth.php';


    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('documents', [DocumentController::class, 'index'])->name('documents');
    });

    // Route::get('storedocs', [PaperController::class, 'store'])->name('docs.store');
});
