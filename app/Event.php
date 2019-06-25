<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	protected $guarded = [];
	
	public function person(){
		return $this->belongsTo(Person::class , 'person_id' , 'id');
	}
}
