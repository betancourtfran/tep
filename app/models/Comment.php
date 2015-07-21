<?php

class Comment extends \Eloquent {

	// Add your validation rules here
	public static $rules = [
		 'body' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['body'];

	public function subject(){
		return $this->belongsTo('Subject');
	}
}