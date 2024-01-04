<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::view('/', 'home')->name('home');
    Route::view('demo', 'demo', ['withoutfooter' => true])->name('demo');
    Route::view('pirce', 'price')->name('price');
    Route::view('testpdf', 'testpdf', ['withoutfooter' => true])->name('testpdf');

    Route::get('testDocument', [DocumentController::class, 'test'])->name('documents.test');

    Route::view('dashboard', 'dashboard')
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->middleware(['auth'])
        ->name('profile');

    require __DIR__ . '/auth.php';


    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('documents', [DocumentController::class, 'index'])->name('documents');
        Route::get('documents/{document}', [DocumentController::class, 'show'])->name('documents.show');

        Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
        Route::get('/pay/{plan}', [PaymentController::class, 'pay'])->name('pay')
            ->whereIn('plan', ['monthly', 'yearly']);

        Route::get('/payment-success', [PaymentController::class, 'success'])->name('payment-success');
        Route::get('/payment-cancel', [PaymentController::class, 'cancel'])->name('payment-cancel');
    });

    // Route::get('storedocs', [PaperController::class, 'store'])->name('docs.store');
});
