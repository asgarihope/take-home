<?php

namespace App\Providers\News;

use Illuminate\Config\Repository as ConfigRepository;

class NewsProvider {

	protected ConfigRepository $configRepository;

	public function __construct(
		ConfigRepository $configRepository,
	) {
		$this->configRepository = $configRepository;
	}
}