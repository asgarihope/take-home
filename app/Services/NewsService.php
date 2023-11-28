<?php

namespace App\Services;

use App\Dtos\NewsDto;
use App\Repositories\Contracts\NewsRepositoryInterface;
use App\Services\Contracts\NewsServiceInterface;
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

	public function createNews(
		string $provider_news_id,
		string $provider,
		string $title,
		string $body,
		string $image,
		string $url,
		string $author,
		string $published_at,
	): NewsDto {
		$newsModel = $this->newsRepository->createNews(
			$provider_news_id,
			$provider,
			$title,
			$body,
			$image,
			$url,
			$author,
			$published_at
		);

		return new NewsDto(
			$newsModel->id,
			$newsModel->provider,
			$newsModel->title,
			$newsModel->category->name,
			$newsModel->body,
			$newsModel->image,
			$newsModel->url,
			$newsModel->author,
			$newsModel->published_at,
		);
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
		return $this->newsRepository->getFilteredNews(
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
	): bool {
		return $this->newsRepository->updateNews(
			$newsID,
			$provider_news_id,
			$provider,
			$title,
			$body,
			$image,
			$url,
			$author,
			$published_at
		);
	}
}