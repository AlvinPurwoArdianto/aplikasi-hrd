<?php

namespace App\Providers;

use App\Models\Absensi;
use App\Models\Cutis;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
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
        View::composer('*', function ($view) {
            // Data untuk notifikasi cuti
            $cutiNotifications = Cutis::where('status_cuti', 'Menunggu')->get();

            // Data untuk notifikasi izin sakit
            $izinSakitCount = Absensi::where('status', 'sakit')->count();

            $view->with([
                'cutiNotifications' => $cutiNotifications,
                'izinSakitCount' => $izinSakitCount,
            ]);

        });

    }
    public function configureMiddleware()
    {
        Route::middlewareGroup('web', [
            \App\Http\Middleware\IsAdmin::class,
            // Middleware lainnya
        ]);
    }

}
