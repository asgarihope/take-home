<?php

namespace App\Providers;

use App\Repositories\Contracts\NewsRepositoryInterface;
use App\Repositories\Eloquent\NewsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 */
	public function register(): void {
		//
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void {
		$this->app->bind(NewsRepositoryInterface::class, NewsRepository::class);
	}
}
