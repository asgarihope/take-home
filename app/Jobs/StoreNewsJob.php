<?php

namespace App\Jobs;

use App\Dtos\NewsDto;
use App\Enums\LogChannelEnum;
use App\Repositories\Contracts\NewsRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class StoreNewsJob implements ShouldQueue {

	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected NewsDto $newsData;

	/**
	 * Create a new job instance.
	 */
	public function __construct(NewsDto $newsData) {
		$this->newsData = $newsData;
	}

	/**
	 * Execute the job.
	 */
	public function handle(NewsRepositoryInterface $newsRepository): void {
		if (!$newsRepository->checkNewsIsExist($this->newsData->provider_news_id)) {

			$news = $newsRepository->createNews(
				$this->newsData->provider_news_id,
				$this->newsData->provider,
				$this->newsData->source,
				$this->newsData->category,
				$this->newsData->title,
				$this->newsData->body,
				$this->newsData->image,
				$this->newsData->url,
				$this->newsData->author,
				$this->newsData->published_at
			);
			Log::channel(LogChannelEnum::LOG)->info('The news added by Id:' . $news->id . ' And its provider is:' . $news->provider);
		}
	}
}
