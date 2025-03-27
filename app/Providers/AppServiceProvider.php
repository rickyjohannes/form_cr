<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
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
        // Tambahkan keamanan tambahan pada header respons
        header('X-XSS-Protection: 1; mode=block');

        // Buat macro untuk semua HTTP request dengan default timeout
        Http::macro('customClient', function () {
            return Http::withOptions([
                'timeout' => 600, // Maksimum waktu menunggu respons (5 menit)
                'connect_timeout' => 120, // Maksimum waktu untuk terhubung (1 menit)
            ]);
        });
    }
}
