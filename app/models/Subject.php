<?php

class Subject extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		 'name' => 'required',
		 'content' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['name', 'content', 'unit_id', 'video'];
	public function units(){
		return $this->belongsTo('Unit');
	}
	public function comments(){
		return $this->hasMany('Comment')->select(['body', 'user_id']);
	}
}