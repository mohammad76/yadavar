<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
	public function index()
	{
		
		if (!auth()->user()) {
			$to = session()->get('to');
			return view('auth.index', [ 'to' => $to ]);
		} else {
			
			return view('auth.account.dashboard');
		}
	}
	
	public function register(Request $request)
	{
		$request->validate([
							   'name'     => 'required|max:255',
							   'email'    => 'required',
							   'password' => 'required',
							   'mobile'   => 'required',
						   ]);
		$user = User::create([
								 'name'     => $request->get('name'),
								 'email'    => $request->get('email'),
								 'mobile'   => $request->get('mobile'),
								 'password' => Hash::make($request->get('password')),
							 ]);
		
		auth()->loginUsingId($user->id);
		
		if ($request->exists('to')) {
			return redirect()->to($request->get('to'));
		}
		
		return redirect()->route('index');
		
		
	}
	
	public function login(Request $request)
	{
		$request->validate([
							   'password' => 'required',
							   'mobile'   => 'required',
						   ]);
		if (Auth::attempt([ 'mobile' => $request->get('mobile'), 'password' => $request->get('password') ])) {
			if ($request->exists('to')) {
				return redirect()->to($request->get('to'));
			}
			
			return redirect()->route('index');
		} else {
			return redirect()->back();
		}
	}
	
	public function logout()
	{
		Auth::logout();
		return redirect()->route('index');
	}
}
