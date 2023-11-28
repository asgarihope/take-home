<?php

namespace App\Services;

use App\Dtos\NewsDto;
use App\Enums\ProviderEnum;
use App\Exceptions\NewsReaderException;
use App\Services\Contracts\NewsReaderServiceInterface;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class NewsReaderService extends DiscoveryService implements NewsReaderServiceInterface {

	private ConfigRepository $configRepository;
	private string $API_KEY;
	private string $BASE_URL;
	private string $ACTIVE;
	private int $PAGE_SIZE = 100;

	public function __construct(
		ConfigRepository $configRepository,
	) {
		$this->configRepository = $configRepository;
		$this->BASE_URL         = $this->configRepository->get('news.news_api.url');
		$this->API_KEY          = $this->configRepository->get('news.news_api.token');

	}

	public function getProviderNewsIdFieldName(): string {
		// TODO: Implement getProviderNewsIdFieldName() method.
		return '';
	}

	public function fetchNews(): Collection {
		try {
			$URL      = $this->BASE_URL . '/everything?' . http_build_query([
					'apiKey'   => $this->API_KEY,
					'sources'  => 'abc-news',
					'pageSize' => $this->PAGE_SIZE
				]);
			$response = Http::withHeaders([
				'Content-Type' => 'application/json',
				'x-api-key'    => $this->API_KEY
			])->get($URL);

			if (isset($response->object()->status, $response->object()->articles) && $response->object()->status === 'ok') {
				return Collection::make($response->object()->articles)->map(function ($news) {
					return new NewsDto(
						null,
						Str::slug($news->title),
						ProviderEnum::NEWS_API,
						$news->source->id,
						$news->title,
						$news->category,
						$news->content,
						$news->urlToImage,
						$news->url,
						$news->author,
						$news->publishedAt,
					);
				});
			}
			throw new NewsReaderException(trans('message.responseIsInvalid'), 400);
		} catch (\Throwable $throwable) {
			throw new NewsReaderException($throwable->getMessage(), $throwable->getCode());
		}
	}

}