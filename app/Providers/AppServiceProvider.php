<?php

namespace App\Providers;

use App\Services\Localization\LocalizationTrackerInterface;
use App\Services\Localization\LocTrackerService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Paginator::useBootstrap();

        // Binding the Localization interface with the current service in use
        $this->app->bind(
            LocalizationTrackerInterface::class,
            LocTrackerService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
