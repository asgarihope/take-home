<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model {

	use HasFactory;

	protected $fillable = [
		'third_party_id',
		'provider',
		'title',
		'category_id',
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
