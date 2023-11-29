<?php

namespace App\Repositories\Eloquent;

use App\Models\News;
use App\Repositories\Contracts\NewsRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\AbstractPaginator;

class NewsRepository extends BaseRepository implements NewsRepositoryInterface {

	public function __construct(News $model) {
		parent::__construct($model);
	}

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
	): Model|News {
		return $this->create([
			'provider_news_id' => $provider_news_id,
			'provider'         => $provider,
			'source'           => $source,
			'category'         => $category,
			'title'            => $title,
			'body'             => $body,
			'image'            => $image,
			'url'              => $url,
			'author'           => $author,
			'published_at'     => $published_at,
		]);
	}

	public function checkNewsIsExist(string $providerNewsID): bool {
		return $this->findBy('provider_news_id', $providerNewsID);
	}

	public function getFilteredNews(
		array $filters,
		array $columns = ['*'],
		array $relations = [],
		array $sorts = ['column' => 'id', 'direction' => 'desc'],
		int   $page = 1,
		int   $perPage = 12
	): AbstractPaginator {
		return $this->getFilteredResources(
			$filters,
			$columns,
			$relations,
			$sorts,
			$page,
			$perPage
		);
	}
}