<?php

class Unit extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		'name' => 'required',
		'content' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['name', 'content'];
	public function subjects()
	{
		return $this->hasMany('Subject')->select(array('name', 'id'));
	}
}