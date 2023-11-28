<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model {

	use HasFactory;

	protected $fillable = [
		'provider_news_id',
		'provider',
		'title',
		'body',
		'image',
		'url',
		'author',
		'published_at',
	];

	public function category() {
		return $this->hasMany(NewsCategory::class);
	}
}
