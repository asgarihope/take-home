<?php

namespace App\Http\Controllers;

use App\Contracts\NewsServiceInterface;
use App\Contracts\RequestUtilsInterface;
use App\Enums\NewsResourceEnum;
use App\Http\Requests\NewsFilterRequest;
use Illuminate\Http\Request;

class NewsController extends Controller {

	private NewsServiceInterface $newsService;
	private RequestUtilsInterface $requestUtils;

	public function __construct(
		NewsServiceInterface  $newsService,
		RequestUtilsInterface $requestUtils
	) {
		$this->newsService  = $newsService;
		$this->requestUtils = $requestUtils;
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
}
