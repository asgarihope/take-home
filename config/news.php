<?php

use App\Enums\ProviderEnum;
use App\Providers\News\Guardian_NewsProvider;
use App\Providers\News\NewsAPI_NewsProvider;
use App\Providers\News\NYTimes_NewsProvider;

return [

	'providers' => [
		ProviderEnum::NEWS_API       => NewsAPI_NewsProvider::class,
		ProviderEnum::GUARDIAN       => Guardian_NewsProvider::class,
		ProviderEnum::NEW_YORK_TIMES => NYTimes_NewsProvider::class,
		// Add more providers here as needed
	],

	ProviderEnum::NEWS_API => [
		'url'   => env('NEWS_API_URL'),
		'token' => env('NEWS_API_TOKEN'),
	],
	ProviderEnum::GUARDIAN => [
		'url'   => env('NEWS_GUARDIAN_URL'),
		'token' => env('NEWS_GUARDIAN_TOKEN'),
	],
	ProviderEnum::NEW_YORK_TIMES => [
		'url'   => env('NEW_YORK_TIMES_URL'),
		'token' => env('NEW_YORK_TIMES_TOKEN'),
	]
];