<?php

namespace App\Providers;

use App\Services\BaseService;
use App\Services\Contracts\BaseServiceInterface;
use App\Services\Contracts\CrawlerNewsServiceInterface;
use App\Services\Contracts\NewsServiceInterface;
use App\Services\NewsService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

	}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(BaseServiceInterface::class,BaseService::class);
        $this->app->bind(NewsServiceInterface::class,NewsService::class);
		$this->app->bind(CrawlerNewsServiceInterface::class,NewsService::class);
    }
}
