<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPackage extends Model
{
	protected $guarded = [];
	protected $dates = ['finish_at'];
	
	public static function check_user_have_package($id){
	
		$user_package = UserPackage::where('user_id' , $id)->first();
		
		if($user_package){
			if($user_package->finish_at->greaterThan(now())){
				return TRUE;
			}
		}
		
		return FALSE;
	}
}
