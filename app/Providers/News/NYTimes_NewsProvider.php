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

class NYTimes_NewsProvider extends NewsProvider implements NewsProviderInterface {

	private ConfigRepository $configRepository;
	private string $API_KEY;
	private string $BASE_URL;
	private string $ACTIVE;
	private int $PAGE_SIZE = 10;

	public function __construct(
		ConfigRepository $configRepository,
	) {
		$this->configRepository = $configRepository;
		$this->BASE_URL         = $this->configRepository->get('news.' . ProviderEnum::NEW_YORK_TIMES . '.url');
		$this->API_KEY          = $this->configRepository->get('news.' . ProviderEnum::NEW_YORK_TIMES . '.token');

	}

	public function fetchNews(int $page = 1): Collection {
		try {
			$URL      = $this->BASE_URL . '/svc/search/v2/articlesearch.json?' . http_build_query([
					'api-key' => $this->API_KEY
				]);
			$response = Http::withHeaders([
				'Content-Type' => 'application/json',
			])->get($URL);
			Log::channel(LogChannelEnum::LOG)->info(ProviderEnum::NEWS_API . ' sended');

			if (isset($response->object()->status, $response->object()->response, $response->object()->response->docs) && $response->object()->status === 'OK') {
				return Collection::make($response->object()->response->docs)->map(function ($news) {
					return new NewsDto(
						null,
						$news->_id,
						ProviderEnum::NEW_YORK_TIMES,
						$news->source??'',
						$news->headline->main,
						$news->type_of_material??'',
						$news->abstract,
						collect($news->multimedia)->first() ? 'https://static01.nyt.com/' . collect($news->multimedia)->first()->url : '',
						$news->web_url,
						collect($news->byline->person)->map(function ($author) {
							return $author->firstname . ' ' . ($author->middlename ?? '') . ' ' . $author->lastname . '(' . $author->role . ')';
						})->join(' - '),
						Carbon::make($news->pub_date),
					);
				});
			}
			throw new NewsReaderException(trans('message.responseIsInvalid'), 400);
		} catch (\Exception  $exception) {
			dd($exception);
			Log::error($exception->getMessage(), ['exception' => $exception]);

			return Collection::make();
		}
	}

}