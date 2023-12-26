<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        dd($languages);
        $locale = 'zh_CN';
        App::setLocale($locale);
    }
}
