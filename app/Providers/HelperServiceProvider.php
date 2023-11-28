<?php

namespace App\Providers;

use App\Contracts\RequestUtilsInterface;
use App\Helpers\RequestUtils;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
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
        $this->app->bind(RequestUtilsInterface::class,RequestUtils::class);
    }
}
