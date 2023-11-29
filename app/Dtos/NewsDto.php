<?php

namespace App\Dtos;

class NewsDto {

	public ?int $id;
	public string $provider_news_id;
	public string $provider;
	public string $source;
	public string $title;
	public string $category;
	public string $body;
	public ?string $image;
	public string $url;
	public string $author;
	public string $published_at;

	public function __construct(
		?int    $id,
		string  $provider_news_id,
		string  $provider,
		string  $source,
		string  $title,
		string  $category,
		string  $body,
		?string $image,
		string  $url,
		string  $author,
		string  $published_at,
	) {
		$this->id               = $id;
		$this->provider_news_id = $provider_news_id;
		$this->provider         = $provider;
		$this->source           = $source;
		$this->title            = $title;
		$this->category         = $category;
		$this->body             = $body;
		$this->image            = $image;
		$this->url              = $url;
		$this->author           = $author;
		$this->published_at     = $published_at;
	}

	public function getKey() {
		return $this->provider_news_id;
	}
}