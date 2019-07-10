<?php

namespace App\Console\Commands;

use App\Event;
use App\Person;
use App\User;
use DateTime;
use Illuminate\Console\Command;

class SendEventHourlyCommand extends Command
{
	
	protected $signature = 'send:event:hourly';
	
	protected $description = 'Process All Hourly Events for Now';
	
	public function handle()
	{
		$hourly_events = Event::whereType('hourly')->get();
		
		foreach ($hourly_events as $event) {
			if ($this->check_hourly_send($event)) {
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
	}
	
	private function check_hourly_send($event)
	{
		
		if($event->last_send_at == NULL){
			return TRUE;
		}
		
		$extra = unserialize($event->extra);
		$time1 = new DateTime();
		$time2 = new DateTime($event->last_send_at);
		$interval = $time1->diff($time2);
		
		$period_check =  $interval->format('%h') >= $extra['hourly_period'];
		
		if($period_check){
			return TRUE;
		}
		
		return FALSE;
	}
}
