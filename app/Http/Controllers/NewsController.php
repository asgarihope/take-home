<?php

namespace App\Http\Controllers;

use App\Contracts\RequestUtilsInterface;
use App\Enums\NewsResourceEnum;
use App\Http\Requests\NewsFilterRequest;
use App\Jobs\StoreNewsJob;
use App\Providers\News\Contracts\NewsProviderInterface;
use App\Providers\News\Guardian_NewsProvider;
use App\Providers\News\NewsAPI_NewsProvider;
use App\Providers\News\NYTimes_NewsProvider;
use App\Services\Contracts\CrawlerNewsServiceInterface;
use App\Services\Contracts\NewsServiceInterface;
use App\Services\NewsService;
use Illuminate\Support\Collection;

class NewsController extends Controller {

	private NewsServiceInterface $newsService;
	private RequestUtilsInterface $requestUtils;
	private CrawlerNewsServiceInterface $crawlerNewsService;

	public function __construct(
		NewsServiceInterface        $newsService,
		RequestUtilsInterface       $requestUtils,
		CrawlerNewsServiceInterface $crawlerNewsService,
	) {
		$this->newsService        = $newsService;
		$this->requestUtils       = $requestUtils;
		$this->crawlerNewsService = $crawlerNewsService;
	}

	public function index(NewsFilterRequest $request) {
		$this->requestUtils->setRequest($request)
			->makeResourceSearchFromRequest(NewsResourceEnum::filterableColumns);

		$sorts   = NewsResourceEnum::sortableColumns[$request->input('sort', 'default')];
		$filters = $request->only(array_keys(NewsResourceEnum::filterableColumns));

		$items = $this->newsService->getFilteredNews(
			$filters,
			$sorts,
			request('page', 1),
			request('perPage', 12)
		);
		dd($items);

	}

	public function test() {
		$res = $this->crawlerNewsService->fetchNews();
//			foreach ($res as $newsItem) {
//				StoreNewsJob::dispatch($newsItem)
		;
////					->onQueue(QueueEnum::NEWS_PROCESSING);
//			}
		$a = $res->map(function ($i) {
			return $i->provider;
		})->toArray();
		dd($a);
	}
}
