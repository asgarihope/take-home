<?php

namespace App\Providers;

use App\Contracts\NewsProviderFactoryInterface;
use App\Providers\News\Contracts\NewsProviderInterface;

class NewsProviderFactory implements NewsProviderFactoryInterface{
	protected $providers;

	public function setProviders(array $providers): void {
		$this->providers = $providers;
	}

	public function create(string $provider): NewsProviderInterface {
		if (!array_key_exists($provider, $this->providers)) {
			throw new \InvalidArgumentException("Provider $provider not found.");
		}

		return app()->make($this->providers[$provider]);
	}
}