<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
{
    // Forzar HTTPS en producción (lo que ya tenías)
    if (env('APP_ENV') === 'production') {
        \Illuminate\Support\Facades\URL::forceScheme('https');
    }

    // Usar las vistas de paginación de Bootstrap 5
    \Illuminate\Pagination\Paginator::useBootstrapFive();
}
}

