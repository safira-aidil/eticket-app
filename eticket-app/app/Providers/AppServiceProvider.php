<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

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
{
    // Ini akan mengirimkan data 'waitingCount' ke semua file blade (termasuk sidebar)
    view()->share('waitingCount', \App\Models\Ticket::where('status', 'waiting')->count());
}
        // Pastikan database tidak error saat migrasi (opsional tapi bagus untuk berjaga-jaga)
        Schema::defaultStringLength(191);

        // Jika kamu menggunakan HTTPS, aktifkan baris di bawah (jika tidak, biarkan saja)
        // if (app()->environment('production')) { URL::forceScheme('https'); }
    }
}