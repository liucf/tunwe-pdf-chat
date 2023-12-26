<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PaperController;
use App\Models\Document;
use App\Models\Paper;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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
    Route::get('documents', [PaperController::class, 'index'])->name('documents');
});

// Route::get('storedocs', [PaperController::class, 'store'])->name('docs.store');
