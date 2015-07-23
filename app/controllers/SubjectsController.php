<?php

class SubjectsController extends \BaseController {
	/**
	* Registra las acciones realizadas
	*
	*/
	public function log_action($action, $message="") {
		$logfile = storage_path().'/logs/transacciones.txt';
		$new = file_exists($logfile) ? false : true;
	  if($handle = fopen($logfile, 'a')) { // append
		$timestamp = strftime("%d-%m-%Y %H:%M:%S", time());
		$content = "{$timestamp} | {$action}: {$message}\n";
		fwrite($handle, $content);
		fclose($handle);
		if($new) { 
			chmod($logfile, 0755);
			return true;
		}
	  } else {
		echo "No se pudo abrir el archivo para escribir.";
	  }
	}
	
	/**
	 * Muestra el formulario para crear un nuevo objetivo
	 *
	 * @return Response
	 */
	public function create($admin, $unitName)
	{
		$units = Unit::whereName($unitName)->get();
		foreach ($units as $unit) {
			$unit = $unit->id;
			return View::make('subjects.create', compact('unit', 'admin'));
		};
		
	}

	/**
	 * Guarda un nuevo objetivo en la base de datos
	 *
	 * @return Response
	 */

	public function store($admin)
	{
		$validator = Validator::make($data = Input::all(), Subject::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		} else {
			Subject::create($data);
			$this->log_action('Objetivo Creado', 'El objetivo "'.Input::get('name'). '" ha sido creado.');
			Session::flash('msj', 'El objetivo ha sido creado exitosamente.');
				return Redirect::route('admin.index', compact('admin'));
		} 
	}

	/**
	 * Muestra el objetivo especificado
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($admin, $name)
	{
		if ($subject = Subject::whereName($name)->first()) {
			return View::make('subjects.show', compact('subject', 'admin'));
		 }

	}

	/**
	 * Muestra el formulario para editar el objetivo especificado
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($admin, $subject_name)
	{
		$subject = Subject::whereName($subject_name)->first();
		return View::make('subjects.edit', compact('subject', 'admin'));
	}

	/**
	 * Actualiza el objetivo especificado en la base de datos
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($admin, $id)
	{

		$subject = Subject::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Subject::$rules);

		if ($validator->fails())
		{
			Session::flash('msj', 'Hubo un error y el objetivo no pudo ser actualizado. Verifique que ningún campo requerido esté vacío.');
			Session::flash('msj_fallido', 'Hubo un error y el objetivo no pudo ser actualizado. Verifique que ningún campo requerido esté vacío.');
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$subject->update($data);
		$this->log_action('Objetivo Actualizado', 'El objetivo "'.$subject->name.'" ha sido actualizado.');
		Session::flash('msj', 'El objetivo ha sido actualizado exitosamente.');
		return Redirect::route('admin.index', ['admin' => $admin]);
	}

	/**
	 * Elimina el objetivo especificado de la base de datos
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($admin, $id)
	{
		$subject = Subject::findOrFail($id);
		if (Subject::destroy($id)){
			$this->log_action('Objetivo Eliminado', 'El objetivo "'.$subject->name. '" ha sido eliminado.');
			Session::flash('msj', 'El objetivo ha sido eliminado exitosamente.');			
			return Redirect::route('admin.index', ['admin' => $admin]);
		} else {
			Session::flash('msj', 'Hubo un error y el objetivo no pudo ser eliminado.');	
			Session::flash('msj_fallido', 'Hubo un error y el objetivo no pudo ser eliminado.');			
			return Redirect::route('admin.index', ['admin' => $admin]);
		}

	}

}
