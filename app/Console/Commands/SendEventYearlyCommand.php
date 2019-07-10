<?php

namespace App\Console\Commands;

use App\Event;
use App\Person;
use App\User;
use Illuminate\Console\Command;

class SendEventYearlyCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 * @var string
	 */
	protected $signature = 'send:event:yearly';
	
	protected $description = 'Process All Yearly Events for Today';
	
	public function handle()
	{
		$yearly_events = Event::whereType('yearly')->get();
		
		foreach ($yearly_events as $event) {
			if ($this->check_yearly_send($event)) {
				$extra  = unserialize($event->extra);
				$user    = User::where('id', $event->user_id)->first();
				$person = Person::where('id', $event->person_id)->first();
				if ($extra['send-sms']) {
					send_sms([ $person->mobile ], $extra['sms-text'] , $user->id, $event->id);
				}
				$event->update([
								   'last_send_at' => now(),
							   ]);
			};
			
			if ($this->check_yearly_remind($event)) {
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
		
		echo 'All Yearly Events Processed' . PHP_EOL;
		
	}
	
	private function check_yearly_send($event)
	{
		$extra          = unserialize($event->extra);
		$last_send_year = date('Y', strtotime($event->last_send_at));
		$month_equal    = date('m', strtotime($event->date)) == date('m');
		$day_equal      = date('d', strtotime($event->date)) == date('d');
		
		if ($month_equal && $day_equal && $last_send_year != date('Y')) {
			return TRUE;
		}
		return FALSE;
	}
	
	private function check_yearly_remind($event)
	{
		$last_remind_at_year = date('Y', strtotime($event->last_remind_at));
		$month_equal         = date('m', strtotime($event->remind_at)) == date('m');
		$day_equal           = date('d', strtotime($event->remind_at)) == date('d');
		
		if ($month_equal && $day_equal && $last_remind_at_year != date('Y')) {
			return TRUE;
		}
		
		return FALSE;
	}
}
