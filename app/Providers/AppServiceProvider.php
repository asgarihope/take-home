<?php

namespace App\Providers;

use App\Services\Contracts\ScheduleConfigServiceInterface;
use App\Services\ScheduleConfigService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
		$this->app->bind(ScheduleConfigServiceInterface::class, ScheduleConfigService::class);

//		$this->app->singleton(ScheduleConfigServiceInterface::class, function ($app) {
//			return new ScheduleConfigService();
//		});
	}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
