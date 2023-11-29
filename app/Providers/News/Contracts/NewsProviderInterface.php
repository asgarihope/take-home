<?php

namespace App\Providers\News\Contracts;

use Illuminate\Support\Collection;

interface NewsProviderInterface {

	public function fetchNews(int $page=1): Collection ;
}