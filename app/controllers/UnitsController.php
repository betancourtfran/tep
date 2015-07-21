<?php

class UnitsController extends \BaseController {

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
	 * Display a listing of units
	 *
	 * @return Response
	 */
	public function index($admin)
	{
		return View::make('admins.index', compact('admin', 'msj'));
	}

	/**
	 * Show the form for creating a new unit
	 *
	 * @return Response
	 */
	public function create($admin)
	{
		return View::make('units.create', compact('admin'));
	}

	/**
	 * Store a newly created unit in storage.
	 *
	 * @return Response
	 */
	public function store($admin)
	{
		$validator = Validator::make($data = Input::all(), Unit::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		if (Unit::create($data)) {
			$this->log_action('Unidad Creada', 'La Unidad "'.Input::get('name'). '" ha sido creada.');
			Session::flash('msj', 'La unidad ha sido creada exitosamente');
			return Redirect::route('admin.index', compact('admin'));
		} else {
			Session::flash('msj', 'La unidad ha sido creada exitosamente');
			return Redirect::route('admin.index', compact('admin'));
		}
	}

	/**
	 * Display the specified unit.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($admin, $unit_name)
	{
		
		$unit = Unit::whereName($unit_name)->first();

		return View::make('units.show', compact('unit', 'admin'));
	}

	/**
	 * Show the form for editing the specified unit.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($admin, $unit_name)
	{
		$unit = Unit::whereName($unit_name)->first();

		return View::make('units.edit', compact('unit', 'admin'));
	}

	/**
	 * Update the specified unit in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($admin, $id)
	{
		$unit = Unit::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Unit::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}
		if($unit->update($data)){
			$this->log_action('Unidad Actualizada', 'La Unidad "'.$unit->name.'" ha sido actualizada.');
			Session::flash('msj', 'La unidad ha sido actualizada exitosamente');
			return Redirect::route('admin.units.index', ['admin' => $admin]);
		} else {
			Session::flash('msj', 'Hubo un error y la Unidad no pudo ser actualizada.');
			Session::flash('msj_fallido', 'Hubo un error y la Unidad no pudo ser actualizada.');
			return Redirect::route('admin.units.index', ['admin' => $admin]);
		}
	}

	/**
	 * Remove the specified unit from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($admin, $id)
	{
		$unit = Unit::findOrFail($id);
		$row = DB::table('subjects')->where('unit_id', $id)->get();
		$subject = $row[0];
		if(Unit::destroy($id) && Subject::destroy($subject->id)){
			$this->log_action('Unidad Eliminada', 'La Unidad "'.$unit->name.'" ha sido eliminada.');
			Session::flash('msj', 'La unidad ha sido eliminada junto con sus objetivos exitosamente.');
			return Redirect::route('admin.index', ['admin' => $admin]);
		} else {
			Session::flash('msj', 'Hubo un error y la Unidad no pudo ser eliminada.');
			Session::flash('msj_fallido', 'Hubo un error y la Unidad no pudo ser eliminada.');
			return Redirect::route('admin.index', ['admin' => $admin]);
		}
	}

}
