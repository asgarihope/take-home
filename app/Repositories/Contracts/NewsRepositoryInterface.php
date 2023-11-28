<?php

namespace App\Repositories\Contracts;

use App\Models\News;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\AbstractPaginator;

interface NewsRepositoryInterface {

	public function createNews(
		string $provider_news_id,
		string $provider,
		string $title,
		string $body,
		string $image,
		string $url,
		string $author,
		string $published_at,
	): Model|News;

	public function updateNews(
		int    $newsID,
		string $provider_news_id,
		string $provider,
		string $title,
		string $body,
		string $image,
		string $url,
		string $author,
		string $published_at,
	): bool;

	public function getNews(int $newsID): Model|News;

	public function getFilteredNews(
		array $filters,
		array $columns = ['*'],
		array $relations = [],
		array $sorts = ['column' => 'id', 'direction' => 'desc'],
		int   $page = 1,
		int   $perPage = 12
	): AbstractPaginator;

	public function deleteNews(int $newsID): bool;
}