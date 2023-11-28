<?php

namespace App\Services;

use App\Contracts\NewsRepositoryInterface;
use App\Contracts\NewsServiceInterface;
use App\Dtos\NewsDto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\AbstractPaginator;

class NewsService extends BaseService implements NewsServiceInterface {

	private NewsRepositoryInterface $newsRepository;

	public function __construct(
		NewsRepositoryInterface $newsRepository,
	) {
		parent::__construct();
		$this->newsRepository = $newsRepository;
	}

	/**
	 * @param array $filters
	 * @param array $sorts
	 * @param int $page
	 * @param int $perPage
	 * @return AbstractPaginator
	 * @return Collection<NewsDto>
	 */
	public function getFilteredNews(array $filters, array $sorts, int $page, int $perPage): AbstractPaginator {
		return $this->newsRepository->getFilteredResources(
			$filters,
			[
				'id',
				'provider',
				'title',
				'body',
				'image',
				'url',
				'author',
				'published_at'
			],
			[
				'category'
			],
			$sorts,
			$page,
			$perPage
		)->map(function ($news) {
			return new NewsDto(
				$news->id,
				$news->provider,
				$news->title,
				$news->category->name,
				$news->body,
				$news->image,
				$news->url,
				$news->author,
				$news->published_at,
			);
		});
	}
}