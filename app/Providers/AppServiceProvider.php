<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
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
        // Deteksi N+1 query di development (throw exception)
        // Di production, hanya log warning
        Model::preventLazyLoading(! $this->app->isProduction());

        // Pastikan semua model harus mass-assign secara eksplisit
        Model::preventSilentlyDiscardingAttributes(! $this->app->isProduction());
    }
}
