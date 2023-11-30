<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsCollection extends JsonResource {

	/**
	 * Transform the resource collection into an array.
	 *
	 * @return array<int|string, mixed>
	 */
	public function toArray(Request $request): array {
		return [
			'localId'    => $this->id,
			'newsId'     => $this->provider_news_id,
			'provider'    => $this->provider,
			'title'       => $this->title,
			'body'        => $this->body,
			'source'      => $this->source,
			'category'    => $this->category,
			'image'       => $this->image,
			'url'         => $this->url,
			'writer'      => $this->author,
			'publishedAt' => $this->published_at,
		];
	}
}
