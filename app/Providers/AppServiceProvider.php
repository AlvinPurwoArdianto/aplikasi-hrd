<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
        //
    }
    public function configureMiddleware()
    {
        Route::middlewareGroup('web', [
            \App\Http\Middleware\IsAdmin::class,
            // Middleware lainnya
        ]);
    }

}
