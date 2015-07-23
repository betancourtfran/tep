<?php

class Unit extends \Eloquent {

	// Agrega las reglas de validación aquí
	public static $rules = [
		'name' => 'required',
		'content' => 'required'
	];

	// Especifica los campos de la base de datos que pueden ser llenados en masa
	protected $fillable = ['name', 'content'];

	//Realiza relación con la tabla el modelo "Subject"
	public function subjects()
	{
		return $this->hasMany('Subject')->select(array('name', 'id'));
	}
}