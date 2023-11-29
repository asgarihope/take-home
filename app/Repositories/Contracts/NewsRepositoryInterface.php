<?php

namespace App\Repositories\Contracts;

use App\Models\News;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\AbstractPaginator;

interface NewsRepositoryInterface {

	public function createNews(
		string $provider_news_id,
		string $provider,
		string $source,
		string $category,
		string $title,
		string $body,
		string $image,
		string $url,
		string $author,
		string $published_at,
	): Model|News;

	public function checkNewsIsExist(string $providerNewsID): bool;

	public function getFilteredNews(
		array $filters,
		array $columns = ['*'],
		array $relations = [],
		array $sorts = ['column' => 'id', 'direction' => 'desc'],
		int   $page = 1,
		int   $perPage = 12
	): AbstractPaginator;
}