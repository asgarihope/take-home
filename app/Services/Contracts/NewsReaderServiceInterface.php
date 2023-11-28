<?php

namespace App\Services\Contracts;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

interface NewsReaderServiceInterface {

	public function getProviderNewsIdFieldName(): string;

	public function fetchNews(): Collection;

}