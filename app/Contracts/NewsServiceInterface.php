<?php

namespace App\Contracts;

use Illuminate\Pagination\AbstractPaginator;

interface NewsServiceInterface {

	public function getFilteredNews(
		array $filters,
		array $sorts,
		int   $page,
		int   $perPage
	): AbstractPaginator;
}