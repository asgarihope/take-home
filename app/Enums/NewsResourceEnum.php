<?php

namespace App\Enums;

final class NewsResourceEnum {

	const ID = "id";
	const TITLE = "title";
	const BODY = "body";
	const IMAGE = "image";
	const URL = "url";
	const AUTHOR = "author";
	const CATEGORY = "category";
	const PUBLISHED_AT = "publishedAt";

	const sortableColumns = [
		'default'                   => ['column' => 'id', 'direction' => SortDirectionEnum::ASCENDING],
		self::PUBLISHED_AT          => ['column' => 'published_at', 'direction' => SortDirectionEnum::ASCENDING],
		self::PUBLISHED_AT . 'Desc' => ['column' => 'published_at', 'direction' => SortDirectionEnum::DESCENDING],

	];

	const filterableColumns = [
		self::ID           => ['column' => 'id', 'type' => ResourceSearchOperatorsEnum::EQUAL_TO],
		self::TITLE        => ['column' => 'title', 'type' => ResourceSearchOperatorsEnum::LIKE],
		self::CATEGORY     => ['column' => 'name', 'type' => ResourceSearchOperatorsEnum::IN_RELATION_LIST],
		self::PUBLISHED_AT => ['column' => 'published_at', 'type' => ResourceSearchOperatorsEnum::BETWEEN_DATE],

	];
}
