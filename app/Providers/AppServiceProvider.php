<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Ticket;
use App\Models\NonAssetTicket;
use App\Models\AssetMaintenance;
use App\Observers\HistoryObserver;

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
    public function boot()
    {
        Ticket::observe(HistoryObserver::class);
        NonAssetTicket::observe(HistoryObserver::class);
        AssetMaintenance::observe(HistoryObserver::class);
    }
}
