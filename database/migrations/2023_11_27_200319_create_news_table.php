<?php

use App\Enums\ProviderEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

	/**
	 * Run the migrations.
	 */
	public function up(): void {
		Schema::create('news', function (Blueprint $table) {
			$table->id();
			$table->string('provider_news_id');
			$table->enum('provider', [
				ProviderEnum::NEWS_API,
				ProviderEnum::NEW_YORK_TIMES,
				ProviderEnum::GUARDIAN
			]);
			$table->string('source');
			$table->string('title');
			$table->string('category');
			$table->longText('body');
			$table->string('image')->nullable();
			$table->text('url'); // the URLs in news api more than 255 char
			$table->string('author');
			$table->dateTime('published_at');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void {
		Schema::dropIfExists('news');
	}
};
