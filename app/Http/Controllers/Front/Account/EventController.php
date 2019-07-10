<?php

namespace App\Http\Controllers\Front\Account;

use App\Event;
use App\Http\Controllers\Controller;
use App\Message;
use App\Person;
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
		
		$user = auth()->user();
		$type = $request->get('type');
		
		$name = $request->get('name');
		
		if ($request->get('person_status') == 'create') {
			$person    = $user->people()->create([
													 'name'   => $request->get('person_name'),
													 'mobile' => $request->get('person_mobile'),
												 ]);
			$person_id = $person->id;
		} else {
			$person_id = $request->get('person_id');
		}
		
		switch ($type) {
			case 'yearly':
				$this->store_yearly_events($request, $user, $type, $person_id, $name);
			break;
			case 'monthly':
				$this->store_monthly_events($request, $user, $type, $person_id, $name);
			break;
			case 'daily':
				$this->store_daily_events($request, $user, $type, $person_id, $name);
			break;
			case 'hourly':
				$this->store_hourly_events($request, $user, $type, $person_id, $name);
			case 'exact':
				$this->store_exact_events($request, $user, $type, $person_id, $name);
			break;
		}
		return redirect()->route('event-index');
	}
	
	private function store_yearly_events($request, $user, $type, $person_id, $name)
	{
		
		$date        = CalendarUtils::toGregorian(jdate()->getYear(), $request->get('yearly_month'), $request->get('yearly_day'));
		$date        = date('Y-m-d', strtotime($date[0] . '-' . $date[1] . '-' . $date[2]));
		$remind_at   = date('Y-m-d', strtotime("-" . $request->get('remind_day') . " day", strtotime($date)));
		$remind_time = $request->get('remind_time');
		$extra       = [
			'yearly_period'      => $request->get('yearly_period'),
			'send-sms'           => $request->exists('send-sms'),
			'sms-text'           => $request->get('sms-text'),
			'remind_email'       => $request->exists('remind_email'),
			'remind_sms'         => $request->exists('remind_sms'),
			'remind_description' => $request->get('remind_description'),
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
	}
	
	private function store_monthly_events($request, $user, $type, $person_id, $name)
	{
		$date        = jdate()->getYear() . '-' . jdate()->getMonth() . '-' . $request->get('monthly_day');
		$remind_at   = date('Y-m-d', strtotime("-" . $request->get('remind_day') . " day", strtotime($date)));
		$remind_time = $request->get('remind_time');
		$extra       = [
			'monthly_period'     => $request->get('monthly_period'),
			'send-sms'           => $request->exists('send-sms'),
			'sms-text'           => $request->get('sms-text'),
			'remind_email'       => $request->exists('remind_email'),
			'remind_sms'         => $request->exists('remind_sms'),
			'remind_description' => $request->get('remind_description'),
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
	}
	
	private function store_daily_events($request, $user, $type, $person_id, $name)
	{
		$date      = now();
		$remind_at = now();
		$extra     = [
			'daily_period'       => $request->get('daily_period'),
			'daily_hour'         => $request->get('daily_hour'),
			'send-sms'           => $request->exists('send-sms'),
			'sms-text'           => $request->get('sms-text'),
			'remind_email'       => $request->exists('remind_email'),
			'remind_sms'         => $request->exists('remind_sms'),
			'remind_description' => $request->get('remind_description'),
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
	
	private function store_hourly_events($request, $user, $type, $person_id, $name)
	{
		$date      = now();
		$remind_at = now();
		$extra     = [
			'hourly_period'      => $request->get('hourly_period'),
			'send-sms'           => $request->exists('send-sms'),
			'sms-text'           => $request->get('sms-text'),
			'remind_email'       => $request->exists('remind_email'),
			'remind_sms'         => $request->exists('remind_sms'),
			'remind_description' => $request->get('remind_description'),
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
	
	private function store_exact_events($request, $user, $type, $person_id, $name)
	{
		$date        = explode('-', $this->ArtoEnNumeric($request->get('exact_date')));
		$date        = CalendarUtils::toGregorian($date[0], $date[1], $date[2]);
		$date        = date('Y-m-d', strtotime($date[0] . '-' . $date[1] . '-' . $date[2]));
		$remind_at   = date('Y-m-d', strtotime("-" . $request->get('remind_day') . " day", strtotime($date)));
		$remind_time = $request->get('remind_time');
		$extra       = [
			'send-sms'           => $request->exists('send-sms'),
			'sms-text'           => $request->get('sms-text'),
			'remind_email'       => $request->exists('remind_email'),
			'remind_sms'         => $request->exists('remind_sms'),
			'remind_description' => $request->get('remind_description'),
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
	}
	
	private function ArtoEnNumeric($string)
	{
		return strtr($string, [ '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9' ]);
	}
	
	public function edit(Event $event)
	{
		$user = auth()->user();
		if ($user->id != $event->user_id) {
			return redirect()->route('event-index');
		}
		$people = $user->people()->get();
		return view('auth.account.events.edit', [ 'event' => $event , 'people' => $people ]);
	}
	
	public function update(Request $request, Event $event)
	{
		$event->update($request->all());
		return redirect()->route('event-index');
	}
	
	public function destroy(Event $event)
	{
		$user = auth()->user();
		if ($user->id == $event->user_id) {
			$event->delete();
		}
		return redirect()->route('event-index');
	}
	
}
