<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
	protected $fillable = ['name', 'last_name', 'email', 'password'];

	// Agrega las reglas de validación aquí
	public static $rules = [
	'name' => 'required',
	'last_name' => 'required',
	'password' => 'required',
	'email' => 'required|unique:users|email',
	'g-recaptcha-response' => 'required|recaptcha'
	];
}
