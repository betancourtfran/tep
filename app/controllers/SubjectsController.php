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
	 * Display a listing of subjects
	 *
	 * @return Response
	 */
	// public function index($admin)
	// {
	// 	$subjects = Subject::all();

	// 	return View::make('admins.index', compact('subjects'));
	// }

	/**
	 * Show the form for creating a new subject
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
	 * Store a newly created subject in storage.
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
	 * Display the specified subject.
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
	 * Show the form for editing the specified subject.
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
	 * Update the specified subject in storage.
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
	 * Remove the specified subject from storage.
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
