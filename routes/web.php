<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::view('demo', 'demo', ['withoutfooter' => true])->name('demo');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
