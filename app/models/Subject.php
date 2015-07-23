<?php

class Subject extends \Eloquent {

	// Agrega las reglas de validación aquí
	public static $rules = [
		 'name' => 'required',
		 'content' => 'required'
	];

	// Especifica los campos de la base de datos que pueden ser llenados en masa
	protected $fillable = ['name', 'content', 'unit_id', 'video'];
	
	//Realiza relación con la tabla el modelo "Unit"
	public function units(){
		return $this->belongsTo('Unit');
	}

}