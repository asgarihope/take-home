<?php

namespace App\Console;

use App\Console\Commands\GetNewsCommand;
use App\Services\Contracts\ScheduleConfigServiceInterface;
use App\Services\ScheduleConfigService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * @var array|mixed
	 */
	private mixed $period;
	private ScheduleConfigService $scheduleConfigService;

	public function __construct(
		Application           $app,
		Dispatcher            $events,
		ScheduleConfigService $scheduleConfigService,
	) {
		parent::__construct($app, $events);
		$this->scheduleConfigService = $scheduleConfigService;
		$this->period                = $this->scheduleConfigService->getSchedulePeriod();
	}

	protected $commands = [
		GetNewsCommand::class
	];

	/**
	 * Define the application's command schedule.
	 */
	protected function schedule(Schedule $schedule): void {
		$schedule->command('get:news')
			->withoutOverlapping()
			->cron('*/' . $this->period . ' * * * *');
	}

	/**
	 * Register the commands for the application.
	 */
	protected function commands(): void {
		$this->load(__DIR__ . '/Commands');

		require base_path('routes/console.php');
	}
}
