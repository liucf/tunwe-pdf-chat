<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::middleware('guest')->group(function () {
    Volt::route('register', 'pages.auth.register')
        ->name('register');

    Volt::route('login', 'pages.auth.login')
        ->name('login');

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');
});

Route::get('auth/github/redirect', function () {
    return Socialite::driver('github')->redirect();
});

Route::get('auth/github/callback', function () {
    $githubUser = Socialite::driver('github')->user();

    $user = User::updateOrCreate([
        'github_id' => $githubUser->id,
    ], [
        'name' => $githubUser->name,
        'email' => $githubUser->email,
        'provider' => 'github',
        'github_token' => $githubUser->token,
        'github_refresh_token' => $githubUser->refreshToken,
        'avatar' => $githubUser->getAvatar(),
        'email_verified_at' => now(),
    ]);
    Auth::login($user);
    return redirect()->route('documents');
});


Route::get('auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    $user = User::updateOrCreate([
        'google_id' => $googleUser->id,
    ], [
        'name' => $googleUser->name,
        'email' => $googleUser->email,
        'provider' => 'google',
        'google_token' => $googleUser->token,
        'google_refresh_token' => $googleUser->refreshToken,
        'avatar' => $googleUser->getAvatar(),
        'email_verified_at' => now(),
    ]);
    Auth::login($user);
    return redirect()->route('documents');
});
