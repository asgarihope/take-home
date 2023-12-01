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

class Guardian_NewsProvider extends NewsProvider implements NewsProviderInterface {

	private const PAGE_SIZE = 10;
	private ConfigRepository $configRepository;
	private string $API_KEY;
	private string $BASE_URL;

	public function __construct(
		ConfigRepository $configRepository,
	) {
		$this->configRepository = $configRepository;
		$this->BASE_URL         = $this->configRepository->get('news.' . ProviderEnum::GUARDIAN . '.url');
		$this->API_KEY          = $this->configRepository->get('news.' . ProviderEnum::GUARDIAN . '.token');
	}

	public function fetchNews(int $page = 1): Collection {
		try {
			$URL      = $this->BASE_URL . '/search?' . http_build_query([
					'api-key'   => $this->API_KEY,
					'page-size' => Guardian_NewsProvider::PAGE_SIZE,
					'page'      => $page
				]);
			$response = Http::withHeaders([
				'Content-Type' => 'application/json'
			])->throw()->get($URL);
			Log::channel(LogChannelEnum::LOG)->info(ProviderEnum::NEWS_API . ' the request sent via provider: '.ProviderEnum::GUARDIAN);

			if (isset($response->object()->response, $response->object()->response->status, $response->object()->response->results) && $response->object()->response->status === 'ok') {
				return Collection::make($response->object()->response->results)->map(function ($news) {
					return new NewsDto(
						null,
						$news->id,
						ProviderEnum::GUARDIAN,
						$news->pillarName,
						$news->webTitle,
						$news->sectionId ?? '',
						$news->webTitle,
						'',
						$news->webUrl,
						'',
						Carbon::make($news->webPublicationDate),
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