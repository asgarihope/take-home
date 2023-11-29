<?php

namespace App\Providers;

use App\Contracts\NewsProviderFactoryInterface;

use Illuminate\Support\ServiceProvider;

class FactoryServiceProvider extends ServiceProvider
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
        $this->app->bind(NewsProviderFactoryInterface::class,NewsProviderFactory::class);
    }
}
