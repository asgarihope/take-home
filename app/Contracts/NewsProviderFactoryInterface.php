<?php

namespace App\Contracts;

use App\Providers\News\Contracts\NewsProviderInterface;

interface NewsProviderFactoryInterface {

	public function setProviders(array $providers): void;

	public function create(string $provider): NewsProviderInterface;

}