<?php

namespace App\Http\Controllers;

use App\Contracts\RequestUtilsInterface;
use App\Enums\NewsResourceEnum;
use App\Http\Requests\NewsFilterRequest;
use App\Services\Contracts\NewsReaderServiceInterface;
use App\Services\Contracts\NewsServiceInterface;

class NewsController extends Controller {

	private NewsServiceInterface $newsService;
	private RequestUtilsInterface $requestUtils;
	private NewsReaderServiceInterface $newsReaderService;

	public function __construct(
		NewsServiceInterface  $newsService,
		RequestUtilsInterface $requestUtils,
		NewsReaderServiceInterface $newsReaderService
	) {
		$this->newsService  = $newsService;
		$this->requestUtils = $requestUtils;
		$this->newsReaderService = $newsReaderService;
	}

	public function index(NewsFilterRequest $request) {
		$this->requestUtils->setRequest($request)
			->makeResourceSearchFromRequest(NewsResourceEnum::filterableColumns);

		$sorts    = NewsResourceEnum::sortableColumns[$request->input('sort', 'default')];
		$filters = $request->only(array_keys(NewsResourceEnum::filterableColumns));

		$items = $this->newsService->getFilteredNews(
			$filters,
			$sorts,
			request('page', 1),
			request('perPage', 12)
		);

	}

	public function test(){
		$this->newsReaderService->fetchNews();
	}
}
