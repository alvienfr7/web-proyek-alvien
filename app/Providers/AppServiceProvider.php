<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Tampilan tombol pagination mengikuti Bootstrap 5, bukan Tailwind (bawaan Laravel)
        Paginator::useBootstrapFive();

        // Agar translatedFormat('d F Y') menghasilkan "02 Oktober 2026", bukan "02 October 2026"
        Carbon::setLocale('id');

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}