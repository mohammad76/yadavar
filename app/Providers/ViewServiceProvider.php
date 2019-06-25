<?php

namespace App\Providers;

use App\UserPackage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 * @return void
	 */
	public function register()
	{
		//
	}
	
	/**
	 * Bootstrap services.
	 * @return void
	 */
	public function boot()
	{
		
		View::composer('layouts.master-auth', function ($view) {
			
			$have_package = UserPackage::check_user_have_package(auth()->user()->id);
			$finish_at = UserPackage::where('user_id' , auth()->user()->id)->first()->finish_at;
			$view->with('have_package', !$have_package);
			$view->with('finish_at', $finish_at);
		});
	}
}
