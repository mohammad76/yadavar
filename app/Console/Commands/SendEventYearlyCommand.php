<?php

namespace App\Console\Commands;

use App\Event;
use App\Person;
use Illuminate\Console\Command;

class SendEventYearlyCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 * @var string
	 */
	protected $signature = 'send:event:yearly';
	
	protected $description = 'Process All Events for Today';
	
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Execute the console command.
	 * @return mixed
	 */
	public function handle()
	{
		$this->yearly_send();
	}
	
	private function yearly_send()
	{
		$yearly_events = Event::whereType('yearly')->get();
		
		foreach ($yearly_events as $event) {
			if ($this->check_yearly_send($event)) {
				$extra = unserialize($event->extra);
				$person = Person::where('id' , $event->person_id)->first();
				if($extra['send-sms']){
					$url = "37.130.202.188/services.jspd";
					
					$rcpt_nm = [ $person->mobile ];
					$param   = [
						'uname'   => 'mamad55',
						'pass'    => '2589654',
						'from'    => '+985000189',
						'message' => $extra['sms-text'],
						'to'      => json_encode($rcpt_nm),
						'op'      => 'send',
					];
					
					$handler = curl_init($url);
					curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($handler, CURLOPT_POSTFIELDS, $param);
					curl_setopt($handler, CURLOPT_RETURNTRANSFER, TRUE);
					$response2 = curl_exec($handler);
					
					$response2 = json_decode($response2);
					$res_code  = $response2[0];
					$res_data  = $response2[1];
					
					echo $res_data;
				}
				
				
//				$event->update([
//								   'last_send_at' => now(),
//							   ]);
			};
		}
		
	}
	
	private function check_yearly_send($event)
	{
		$extra = unserialize($event->extra);
		if ($event->last_send_at == NULL) {
			return TRUE;
		}
		$last_send_year = date('Y', strtotime($event->last_send_at));
		if ($event->date == date('Y-m-d') && $last_send_year != date('Y')) {
			return TRUE;
		}
		return FALSE;
	}
}
