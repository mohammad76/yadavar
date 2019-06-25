<?php

namespace App\Http\Controllers\Front\Account;

use App\Event;
use App\Person;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PersonController extends Controller
{
	public function index()
	{
		
		$user   = auth()->user();
		$people = $user->people()->get();
		return view('auth.account.people.index', [ 'people' => $people ]);
	}
	
	public function create()
	{
		
		return view('auth.account.people.create');
	}
	
	public function store(Request $request)
	{
		
		$user   = auth()->user();
		$person = $user->people()->create($request->only('name', 'mobile'));
		
		return redirect()->route('people-index');
	}
	
	public function edit(Person $person)
	{
		$user = auth()->user();
		if ($user->id != $person->user_id) {
			return redirect()->route('people-index');
		}
		
		
		return view('auth.account.people.edit', [ 'person' => $person ]);
	}
	
	public function update(Request $request, Person $person)
	{
		$person->update($request->all());
		return redirect()->route('people-index');
	}
	
	public function destroy(Person $person)
	{
		$user = auth()->user();
		if ($user->id == $person->user_id) {
			$person->delete();
		}
		return redirect()->route('people-index');
	}
}
