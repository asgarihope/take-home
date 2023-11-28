<?php

namespace App\Dtos;

use App\Models\NewsCategory;

class NewsDto {

	public function __construct(
		int     $id,
		string  $provider,
		string  $title,
		string  $category,
		string  $body,
		?string $image,
		string  $url,
		string  $author,
		string  $published_at,
	) {
	}


}