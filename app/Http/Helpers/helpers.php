<?php
function daily_next_date($date, $daily_period, $daily_hour)
{
	$day_of_week = jdate($date)->getDayOfWeek();
	if (in_array($day_of_week, $daily_period)) {
		if ($daily_hour >= date('H')) {
			return $date;
		} else {
			return daily_next_date( date('Y-m-d', strtotime($date . "+1 day")), $daily_period, 24);
		}
		
	} else {
		$date = date('Y-m-d', strtotime($date . "+1 day"));
		
		return daily_next_date($date, $daily_period , $daily_hour);
	}
}