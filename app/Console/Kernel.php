<?php

namespace App\Console;

use App\Console\Commands\SendEventDailyCommand;
use App\Console\Commands\SendEventHourlyCommand;
use App\Console\Commands\SendEventMonthlyCommand;
use App\Console\Commands\SendEventYearlyCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	protected $commands = [
		SendEventYearlyCommand::class,
		SendEventMonthlyCommand::class,
		SendEventDailyCommand::class,
		SendEventHourlyCommand::class,
	];
	
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('send:event:hourly')->hourly();
		$schedule->command('send:event:daily')->hourly();
		$schedule->command('send:event:monthly')->dailyAt('13:00');
		$schedule->command('send:event:yearly')->dailyAt('11:00');
	}
	
	protected function commands()
	{
		$this->load(__DIR__ . '/Commands');
		
		require base_path('routes/console.php');
	}
}
