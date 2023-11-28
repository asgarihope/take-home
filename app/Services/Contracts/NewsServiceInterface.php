<?php

namespace App\Services\Contracts;

use App\Dtos\NewsDto;
use Illuminate\Pagination\AbstractPaginator;

interface NewsServiceInterface {

	public function createNews(
		string $provider_news_id,
		string $provider,
		string $title,
		string $body,
		string $image,
		string $url,
		string $author,
		string $published_at,
	): NewsDto;

	public function getFilteredNews(
		array $filters,
		array $sorts,
		int   $page,
		int   $perPage
	): AbstractPaginator;

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
}