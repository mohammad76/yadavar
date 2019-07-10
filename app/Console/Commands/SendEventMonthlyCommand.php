<?php

namespace App\Console\Commands;

use App\Event;
use App\Person;
use App\User;
use Illuminate\Console\Command;

class SendEventMonthlyCommand extends Command
{
	
	protected $signature = 'send:event:monthly';
	
	protected $description = 'Process All Monthly Events for Today';
	
	
	public function handle()
	{
		$monthly_events = Event::whereType('monthly')->get();
		
		foreach ($monthly_events as $event) {
			if ($this->check_monthly_send($event)) {
				$extra  = unserialize($event->extra);
				$user   = User::where('id', $event->user_id)->first();
				$person = Person::where('id', $event->person_id)->first();
				if ($extra['send-sms']) {
					send_sms([ $person->mobile ], $extra['sms-text'], $user->id, $event->id);
				}
				$event->update([
								   'last_send_at' => now(),
							   ]);
				
			}
			
			if ($this->check_monthly_remind($event)) {
				$user    = User::where('id', $event->user_id)->first();
				$person  = Person::where('id', $event->person_id)->first();
				$extra   = unserialize($event->extra);
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
		
		echo 'All Monthly Events Processed' . PHP_EOL;
	}
	
	private function check_monthly_send($event)
	{
		$date            = explode('-', $event->date);
		$extra           = unserialize($event->extra);
		$last_send_month = date('m', strtotime($event->last_send_at));
		$day_equal       = jdate()->getDay() == $date[2];
		$period_check    = date('m') - $last_send_month == $extra['monthly_period'];
		if ($period_check && $day_equal && $event->last_send_at == NULL) {
			return TRUE;
		}
		if ($day_equal && $last_send_month != date('m') && $period_check) {
			return TRUE;
		}
		
		return FALSE;
	}
	
	private function check_monthly_remind($event)
	{
		$extra             = unserialize($event->extra);
		$date              = explode('-', explode(' ', $event->remind_at)[0]);
		$day_equal         = jdate()->getDay() == $date[2];
		$last_remind_month = date('m', strtotime($event->last_remind_at));
		$period_check      = date('m') - $last_remind_month == $extra['monthly_period'];
		if ($period_check && $day_equal && $event->last_remind_at == NULL) {
			
			return TRUE;
		}
		
		if ($day_equal && $last_remind_month != date('m') && $period_check) {
			return TRUE;
		}
		
		return FALSE;
	}
}
