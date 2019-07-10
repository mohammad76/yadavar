<?php

namespace App\Console\Commands;

use App\Event;
use App\Person;
use App\User;
use Illuminate\Console\Command;

class SendEventDailyCommand extends Command
{
	
	protected $signature = 'send:event:daily';
	
	
	protected $description = 'Process All Daily Events for Today';
	
	public function handle()
	{
		$daily_events = Event::whereType('daily')->get();
		
		foreach ($daily_events as $event) {
			if ($this->check_daily_send($event)) {
				$extra  = unserialize($event->extra);
				$user   = User::where('id', $event->user_id)->first();
				$person = Person::where('id', $event->person_id)->first();
				if ($extra['send-sms']) {
					send_sms([ $person->mobile ], $extra['sms-text'], $user->id, $event->id);
				}
				$event->update([
								   'last_send_at' => now(),
							   ]);
				
				// remind
				
				$message = "یادوآوری رویداد " . $event->name . "\nفرد مرتبط: " . $person->name . "\nتوضیحات: " . $extra['remind_description'];
				if ($extra['remind_sms']) {
					send_sms([ $user->mobile ], $message, $user->id, $event->id);
				}
				if ($extra['remind_email']) {
					// send email
				}
				
				$event->update([
								   'last_remind_at' => now(),
							   ]);
			}
		}
		
		echo 'All Daily Events Processed' . PHP_EOL;
	}
	
	private function check_daily_send($event)
	{
		$extra       = unserialize($event->extra);
		$hour_equal  = date('H') == $extra['daily_hour'];
		$day_of_week = jdate()->getDayOfWeek();
		if (in_array($day_of_week, $extra['daily_period']) && $hour_equal && $event->last_send_at == NULL) {
			return TRUE;
		}
		
		$last_send_day = date('d', strtotime($event->last_send_at));
		
		if (in_array($day_of_week, $extra['daily_period']) && $hour_equal && $last_send_day != date('d')) {
			return TRUE;
		}
		
		return FALSE;
	}
}
