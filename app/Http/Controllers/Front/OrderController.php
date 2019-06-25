<?php

namespace App\Http\Controllers\Front;

use App\Package;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
	public function index(Package $package)
	{
		if(!auth()->user()){
			
			return redirect()->route('auth-index')->with( ['to' => url()->current() ] );
		}
		return view('orders.index' , ['package' => $package]);
	}
}
