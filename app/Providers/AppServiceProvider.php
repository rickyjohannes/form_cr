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
        // Add headers to your responses
        header('X-XSS-Protection: 1; mode=block');
        // You can add more headers like X-Content-Type-Options, Content-Security-Policy, etc.

        Http::globalOptions([
            'timeout' => 300, // batas waktu respons dalam detik
            'connect_timeout' => 60, // batas waktu koneksi dalam detik
        ]);
    }
}
