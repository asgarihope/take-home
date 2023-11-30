<?php

namespace App\Services;

use App\Services\Contracts\ScheduleConfigServiceInterface;

class ScheduleConfigService implements ScheduleConfigServiceInterface {

	public function getSchedulePeriod(): int {
		return (int)env('SCHEDULE_PERIOD_MINUTES', 10);
	}
}