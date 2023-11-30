<?php

namespace App\Services;

use App\Contracts\NewsProviderFactoryInterface;
use App\Dtos\NewsDto;
use App\Repositories\Contracts\NewsRepositoryInterface;
use App\Services\Contracts\NewsServiceInterface;
use Carbon\Carbon;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;

class NewsService extends BaseService implements NewsServiceInterface {

	private NewsRepositoryInterface $newsRepository;
	private NewsProviderFactoryInterface $newsProviderFactory;
	private ConfigRepository $configRepository;

	public function __construct(
		ConfigRepository             $configRepository,
		NewsProviderFactoryInterface $providerFactory,
		NewsRepositoryInterface      $newsRepository,
	) {
		parent::__construct();
		$this->newsRepository      = $newsRepository;
		$this->newsProviderFactory = $providerFactory;
		$this->configRepository    = $configRepository;
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
	): ?NewsDto {
		$newsModel = $this->newsRepository->createNews(
			$provider_news_id,
			$provider,
			$source,
			$category,
			$title,
			$body,
			$image,
			$url,
			$author,
			$published_at
		);

		return new NewsDto(
			$newsModel->id,
			$newsModel->provider_news_id,
			$newsModel->provider,
			$newsModel->source,
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
	 * @return Collection<NewsDto>
	 */
	public function getFilteredNews(array $filters, array $sorts, int $page, int $perPage): Collection {
		$res= $this->newsRepository->getFilteredNews(
			$filters,
			[
				'id',
				'provider',
				'provider_news_id',
				'title',
				'category',
				'source',
				'body',
				'image',
				'url',
				'author',
				'published_at'
			],
			[],
			$sorts,
			$page,
			$perPage
		);
//		dd($res);
//		return  nw
		return $res->appends([
//			'currentPage'=>$res->currentPage,
//			'lastPage'=>$res->lastPage,
		])->map(function ($news) {
			return new NewsDto(
				$news->id,
				$news->provider_news_id,
				$news->provider,
				$news->source,
				$news->title,
				$news->category,
				$news->body,
				$news->image,
				$news->url,
				$news->author,
				$news->published_at,
			);
		});
	}

	public function fetchNews(): Collection {
		$allNews   = Collection::make();
		$providers = $this->configRepository->get('news.providers');
		$this->newsProviderFactory->setProviders($providers);
		foreach ($providers as $provider => $providerClass) {
			$newsProvider = $this->newsProviderFactory->create($provider);
			$news         = $newsProvider->fetchNews();
			$news         = $news->map(function ($item) {
				$item->published_at = Carbon::make($item->published_at);

				return $item;
			});
			$allNews      = $allNews->merge($news)->sort(function ($item) {
				return $item->published_at;
			});
		}

		return $allNews;
	}
}