<?php

namespace App\Services\Contracts;

use App\Enums\ProviderEnum;

interface DiscoveryServiceInterface {

	public function fetch(ProviderEnum $provider);
}