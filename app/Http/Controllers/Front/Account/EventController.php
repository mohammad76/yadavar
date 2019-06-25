<?php

namespace App\Http\Controllers\Front\Account;

use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function  index(){
		$user   = auth()->user();
		$events = $user->events()->with('person')->get();
		
    	return view('auth.account.events.index' , ['events' => $events]);
	}
}
