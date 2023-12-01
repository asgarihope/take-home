<?php

namespace App\Providers\News;

use App\Dtos\NewsDto;
use App\Enums\LogChannelEnum;
use App\Enums\ProviderEnum;
use App\Exceptions\NewsReaderException;
use App\Providers\News\Contracts\NewsProviderInterface;
use Carbon\Carbon;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewsAPI_NewsProvider extends NewsProvider implements NewsProviderInterface {

	private const CATEGORY = 'abc-news';
	private const PAGE_SIZE = 10;
	private ConfigRepository $configRepository;
	private string $API_KEY;
	private string $BASE_URL;

	public function __construct(
		ConfigRepository $configRepository,
	) {
		$this->configRepository = $configRepository;
		$this->BASE_URL         = $this->configRepository->get('news.' . ProviderEnum::NEWS_API . '.url');
		$this->API_KEY          = $this->configRepository->get('news.' . ProviderEnum::NEWS_API . '.token');
	}

	public function fetchNews(int $page = 1): Collection {
		try {
			$URL      = $this->BASE_URL . '/v2/everything?' . http_build_query([
					'apiKey'   => $this->API_KEY,
					'sources'  => NewsAPI_NewsProvider::CATEGORY,
					'pageSize' => NewsAPI_NewsProvider::PAGE_SIZE
				]);
			$response = Http::withHeaders([
				'Content-Type' => 'application/json',
				'x-api-key'    => $this->API_KEY
			])->get($URL);
			Log::channel(LogChannelEnum::LOG)->info(ProviderEnum::NEWS_API . ' the request sent via provider: '.ProviderEnum::NEWS_API);
			if (isset($response->object()->status, $response->object()->articles) && $response->object()->status === 'ok') {
				return Collection::make($response->object()->articles)->map(function ($news) {
					return new NewsDto(
						null,
						Str::slug($news->title),
						ProviderEnum::NEWS_API,
						$news->source->id,
						$news->title,
						$news->category ?? '',
						$news->content,
						$news->urlToImage,
						$news->url,
						$news->author,
						Carbon::make($news->publishedAt),
					);
				});
			}
			throw new NewsReaderException(trans('message.responseIsInvalid'), 400);
		} catch (\Exception  $exception) {
			Log::error($exception->getMessage(), ['exception' => $exception]);

			return Collection::make();
		}
	}

}