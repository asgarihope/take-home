<?php

namespace App\Services\Contracts;


use Illuminate\Support\Collection;

interface CrawlerNewsServiceInterface {
	public function fetchNews():Collection;
}