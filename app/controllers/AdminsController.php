<?php



class AdminsController extends \BaseController {

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
	 * Display a listing of admins
	 *
	 * @return Response
	 */
	public function index($admin)
	{
		View::share('admin', $admin);
		return View::make('admins.index', compact('admin', 'msj'));
	}

	/**
	 * Show the form for creating a new admin
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admins.create');
	}

	/**
	 * Store a newly created admin in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = Validator::make($data = Input::all(), Admin::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Admin::create($data);

		return Redirect::route('admin.index');
	}

	/**
	 * Display the specified admin.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$admin = Admin::findOrFail($id);

		return View::make('admins.show', compact('admin'));
	}

	/**
	 * Show the form for editing the specified admin.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$admin = Admin::find($id);

		return View::make('admins.edit', compact('admin'));
	}

	/**
	 * Update the specified admin in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$admin = Admin::findOrFail($id);

		$validator = Validator::make($data = Input::all(), Admin::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$admin->update($data);

		return Redirect::route('admin.index');
	}

	/**
	 * Remove the specified admin from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Admin::destroy($id);

		return Redirect::route('admin.index');
	}
	public function help($admin){ return View::make('users.help', compact('admin'));}

	public function db_backup($admin)
	{
		if($db_backup = glob(storage_path().'/app/*.gz'))
		{
			unlink($backup_route = array_pop($db_backup));
		}

		$exit_code = Artisan::call('db:backup',
			[
				'--database' 		=> 'mysql',
				'--destination'		=> 'local',
				'--destinationPath'	=> 'Respaldo-Base-de-Datos-'.strftime("%d-%m-%Y %H:%M:%S", time()),
				'--compression'		=> 'gzip'
			]);
		if ($exit_code) {
			Session::flash('msj', 'Hubo un error y no pudo respaldarse la base de datos.');
			Session::flash('msj_fallido', 'Hubo un error y no pudo respaldarse la base de datos.');
			return Redirect::route('admin.index', ['admin' => $admin]);

		} else {
			$this->log_action('Base de Datos Respaldada', 'La Base de Datos ha sido respaldada.');
			Session::flash('msj', 'La base de datos ha sido respaldada con exito.');
			return Redirect::route('admin.index', ['admin' => $admin]);
		}
	}

	public function db_restore($admin)
	{
		$backup_name;
		if($db_backup = glob(storage_path().'/app/*.gz')){
			$backup_route = array_pop($db_backup);
			$backup_name = trim($backup_route, '/var/www/lamp/app/storage/app/');
		}
		$exit_code = Artisan::call('db:restore',
			[
				'--source'  	=> 'local',
				'--sourcePath'	=> $backup_name,
				'--database' 	=> 'mysql',
				'--compression' => 'gzip'
			]);
		if($exit_code) {
			Session::flash('msj', 'Hubo un error y no pudo restaurarse la base de datos.');
			Session::flash('msj_fallido', 'Hubo un error y no pudo restaurarse la base de datos.');
			return Redirect::route('admin.index', ['admin' => $admin]);
		} else {
			$this->log_action('Base de Datos Restaurada', 'La Base de Datos ha sido restaurada.');
			Session::flash('msj', 'La base de datos ha sido restaurada con exito.');
			return Redirect::route('admin.index', ['admin' => $admin]);
		}
	}

	public function transactions($admin)
	{
		$log_route = glob(storage_path().'/logs/*.txt');
		$logfile = array_pop($log_route);
		if (file_exists($logfile) && is_readable($logfile) && $handle = fopen($logfile, 'r')) {
			return View::make('admins.transactions', compact('handle', 'admin'));
		} else {
			Session::flash('msj','No se puede leer el registro de transacciones.');
			Session::flash('msj_fallido','No se puede leer el registro de transacciones.');
			return Redirect::route('admin.index', ['admin' => $admin]);
		}	
	}
	public function delete_transactions($admin)
	{
		$log_route = glob(storage_path().'/logs/*.txt');
		$logfile = array_pop($log_route);
		if(file_put_contents($logfile, '')){
			Session::flash('msj', 'Hubo un error y el registro de acciones realizadas no pudo ser eliminado.');
			Session::flash('msj_fallido', 'Hubo un error y el registro de acciones realizadas no pudo ser eliminado.');
			return Redirect::route('admin.transactions', ['admin' => $admin]);
		} else {
			$this->log_action('Registro de acciones realizadas ha sido eliminado');
			Session::flash('msj', 'El registro de las acciones realizadas ha sido eliminado.');
			return Redirect::route('admin.transactions', ['admin' => $admin]);
			
		}
	}
}
