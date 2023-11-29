<?php

namespace App\Console;

use App\Console\Commands\GetNewsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	protected $commands = [
		GetNewsCommand::class
	];

	/**
	 * Define the application's command schedule.
	 */
	protected function schedule(Schedule $schedule): void {
		$schedule->command('get:news')->everyMinute();
	}

	/**
	 * Register the commands for the application.
	 */
	protected function commands(): void {
		$this->load(__DIR__ . '/Commands');

		require base_path('routes/console.php');
	}
}
