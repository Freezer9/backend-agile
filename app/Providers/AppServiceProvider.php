<?php

namespace App\Providers;

use AgileTeknik\Auth\AuthConfigurator;
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
        $this->app->make(AuthConfigurator::class)->useResetPassword()->useFrontendDomain();
    }
}
