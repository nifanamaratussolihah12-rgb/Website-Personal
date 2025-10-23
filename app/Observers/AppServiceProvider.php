<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\AssetMaintenance;
use App\Observers\AssetMaintenanceObserver;

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
        AssetMaintenance::observe(AssetMaintenanceObserver::class);
    }
}
