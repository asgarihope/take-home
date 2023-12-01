<?php

namespace App\Console\Commands;

use App\Enums\QueueEnum;
use App\Jobs\StoreNewsJob;
use App\Services\Contracts\CrawlerNewsServiceInterface;
use Illuminate\Console\Command;

class GetNewsCommand extends Command {

	private CrawlerNewsServiceInterface $newsService;

	public function __construct(
		CrawlerNewsServiceInterface $newsService
	) {
		parent::__construct();
		$this->newsService = $newsService;
	}

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'get:news';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Execute the console command.
	 */
	public function handle() {
		$newsFromSources = $this->newsService->fetchNews();

		foreach ($newsFromSources as $newsItem) {
			StoreNewsJob::dispatch($newsItem)->onQueue(QueueEnum::NEWS_PROCESSING);
		}
	}
}
