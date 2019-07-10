<?php
function daily_next_date($date, $daily_period, $daily_hour)
{
	$day_of_week = jdate($date)->getDayOfWeek();
	if (in_array($day_of_week, $daily_period)) {
		if ($daily_hour <= date('H')) {
			return daily_next_date(date('Y-m-d', strtotime($date . "+1 day")), $daily_period, 24);
		}
		return $date;
		
	}
	$date = date('Y-m-d', strtotime($date . "+1 day"));
	return daily_next_date($date, $daily_period, $daily_hour);
	
}

function send_sms($mobiles, $message, $user_id, $event_id)
{
	$user = \App\User::where('id', $user_id)->first();
	if ($user->send_limit > 0) {
		$url     = "37.130.202.188/services.jspd";
		$rcpt_nm = $mobiles;
		$param   = [
			'uname'   => 'mamad55',
			'pass'    => '2589654',
			'from'    => '+985000189',
			'message' => $message,
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
		
		$user->update([
						  'send_limit' => $user->send_limit - 1,
					  ]);
		\App\Message::create([
								 'mobile'   => serialize($rcpt_nm),
								 'body'     => $message,
								 'user_id'  => $user_id,
								 'event_id' => $event_id,
							 ]);
		return TRUE;
	}
	return FALSE;
}


