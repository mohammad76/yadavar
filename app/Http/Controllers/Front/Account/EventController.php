<?php

namespace App\Http\Controllers\Front\Account;

use App\Event;
use App\Http\Controllers\Controller;
use App\Message;
use Illuminate\Http\Request;
use Morilog\Jalali\CalendarUtils;

class EventController extends Controller
{
	public function index()
	{
		$user   = auth()->user();
		$events = $user->events()->with('person')->get();
		
		return view('auth.account.events.index', [ 'events' => $events ]);
	}
	
	public function create()
	{
		$user   = auth()->user();
		$people = $user->people()->get();
		return view('auth.account.events.create', [ 'people' => $people ]);
	}
	
	public function store(Request $request)
	{
		
		$user      = auth()->user();
		$type      = $request->get('type');
		$person_id = $request->get('person_id');
		$name      = $request->get('name');
		if ($type == 'yearly') {
			
			$date        = CalendarUtils::toGregorian(jdate()->getYear(), $request->get('yearly_month'), $request->get('yearly_day'));
			$date        = date('Y-m-d', strtotime($date[0] . '-' . $date[1] . '-' . $date[2]));
			$remind_at   = date('Y-m-d', strtotime("-" . $request->get('remind_day') . " day", strtotime($date)));
			$remind_time = $request->get('remind_time');
			$extra       = [
				'yearly_period' => $request->get('yearly_period'),
				'send-sms' => $request->exists('send-sms'),
				'sms-text'  => $request->get('sms-text'),
			];
			$event       = $user->events()->create([
													   'name'        => $name,
													   'person_id'   => $person_id,
													   'date'        => $date,
													   'remind_at'   => $remind_at,
													   'remind_time' => $remind_time,
													   'type'        => $type,
													   'extra'       => serialize($extra),
												   ]);
		} elseif ($type == 'monthly') {
			$date        = jdate()->getYear() . '-' . jdate()->getMonth() . '-' . $request->get('monthly_day');
			$remind_at   = date('Y-m-d', strtotime("-" . $request->get('remind_day') . " day", strtotime($date)));
			$remind_time = $request->get('remind_time');
			$extra       = [
				'monthly_period' => $request->get('monthly_period'),
				'send-sms' => $request->exists('send-sms'),
				'sms-text'  => $request->get('sms-text'),
			];
			$event       = $user->events()->create([
													   'name'        => $name,
													   'person_id'   => $person_id,
													   'date'        => $date,
													   'remind_at'   => $remind_at,
													   'remind_time' => $remind_time,
													   'type'        => $type,
													   'extra'       => serialize($extra),
												   ]);
		} elseif ($type == 'daily') {
			
			$date      = now();
			$remind_at = now();
			$extra     = [
				'daily_period' => $request->get('daily_period'),
				'daily_hour'   => $request->get('daily_hour'),
				'send-sms' => $request->exists('send-sms'),
				'sms-text'  => $request->get('sms-text'),
			];
			$event     = $user->events()->create([
													 'name'        => $name,
													 'person_id'   => $person_id,
													 'date'        => $date,
													 'remind_at'   => $remind_at,
													 'remind_time' => 0,
													 'type'        => $type,
													 'extra'       => serialize($extra),
												 ]);
			
		}
		
		
		dd($request->all());
	}
	
	public function send()
	{
		
		
		//		$this->monthly_send();
		//		 $this->daily_send();
		
	}
	
	private function daily_send()
	{
		$daily_events = Event::whereType('daily')->get();
		
		$all = [];
		foreach ($daily_events as $event) {
			if ($this->check_daily_send($event)) {
				$all[] = $event;
			};
		}
		return $all;
	}
	
	private function monthly_send()
	{
		$monthly_events = Event::whereType('monthly')->whereDay('date', '=', jdate()->getDay())->get();
		$all            = [];
		foreach ($monthly_events as $event) {
			if ($this->check_monthly_send($event)) {
				$all[] = $event;
			};
		}
		return $all;
	}
	
	private function check_monthly_send($event)
	{
		$extra = unserialize($event->extra);
		if ($event->last_send_at == NULL) {
			return TRUE;
		}
		
		if (jdate(strtotime($event->last_send_at))->getMonth() + $extra['monthly_period'] <= jdate()->getMonth()) {
			return TRUE;
		}
		
		return FALSE;
	}
	
	private function check_daily_send($event)
	{
		$extra = unserialize($event->extra);
		if ($event->last_send_at == NULL) {
			return TRUE;
		}
		$day_of_week   = jdate()->getDayOfWeek();
		$now_hour      = date('H');
		$last_send_day = date('d', strtotime($event->last_send_at));
		
		if (in_array($day_of_week, $extra['daily_period']) && $extra['daily_hour'] == $now_hour && $last_send_day != date('d')) {
			return TRUE;
		}
		
		return FALSE;
	}
	
}
