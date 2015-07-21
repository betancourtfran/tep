<?php

class UsersController extends \BaseController {

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
	 * Display a listing of users
	 *
	 * @return Response
	 */
	public function index($admin)
	{
		$users = User::all();
		
		return View::make('users.index', compact('users', 'admin'));
	}

	/**
	 * Show the form for creating a new user
	 *
	 * @return Response
	 */
	public function create($admin = null)
	{
		return View::make('users.create', compact('admin'));
	}

	/**
	 * Store a newly created user in storage.
	 *
	 * @return Response
	 */
	public function store($admin = null)
	{
		if (Input::get('password')) {
		$data = [
			'name' => Input::get('name'),
			'last_name' => Input::get('last_name'),
			'email' => Input::get('email'),
			'password' => Hash::make(Input::get('password')),
			'g-recaptcha-response' => Input::get('g-recaptcha-response')
			];
		} else {
			$data = [
				'name' => Input::get('name'),
				'last_name' => Input::get('last_name'),
				'email' => Input::get('email'),
				'password' => Input::get('password'),
				'g-recaptcha-response' => Input::get('g-recaptcha-response')
			];
		}
		$validator = Validator::make($data, User::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withInput()->withErrors($validator->messages());
		}

		if (User::create($data)){
			
			$this->log_action('Estudiante Registrado', 'El Estudiante "'.Input::get('name'). '" ha sido registrado.');
			Session::flash('msj', 'Usted se ha registrado con éxito.');
			
			if (Auth::admin()->check())
				{
					Session::flash('msj', 'El estudiante fue registrado con éxito.');
					return Redirect::route('admin.users.index', compact('admin'));
				}
			return Redirect::to('/');
		} else {
			Session::flash('msj', 'Hubo un error y el Estudiante no pudo ser registrado');
			return Redirect::to('/');
		}
	}

	/**
	 * Display the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($admin, $user_name)
	{
		$user = User::whereName($user_name)->first();

		return View::make('users.show', compact('user', 'admin'));
	}

	/**
	 * Show the form for editing the specified user.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);

		return View::make('users.edit', compact('user'));
	}

	/**
	 * Update the specified user in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = User::findOrFail($id);

		$validator = Validator::make($data = Input::all(), User::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$user->update($data);

		return Redirect::route('users.index');
	}

	/**
	 * Remove the specified user from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($admin, $id)
	{
		$user = User::findOrFail($id);
		if (User::destroy($id)) {
			$this->log_action('Estudiante Eliminado', 'El Estudiante "'.$user->name.'" ha sido eliminado.');
			Session::flash('msj', 'El estudiante ha sido eliminado exitosamente');
			return Redirect::route('admin.users.index',['admin' => $admin]);
		} else {
			Session::flash('msj', 'Hubo un error y el Estudiante no pudo ser eliminado');
			Session::flash('msj_fallido', 'Hubo un error y el Estudiante no pudo ser eliminado');
			return Redirect::route('admin.users.index',['admin' => $admin]);
		}

	}
	
	public function login()
		{
			if (Input::get('g-recaptcha-response')){
				$credentials = array(
				'email' => Input::get('email'),
				'password' => Input::get('password')
				);
				if (Auth::user()->attempt($credentials)) {		
						$user = Auth::user()->get()->name;
						return Redirect::route('admin.index', ['admin' => $user]);
					} elseif (Auth::admin()->attempt($credentials)) {
						$admin = Auth::admin()->get()->name;
						return Redirect::route('admin.index', ['admin' => $admin]);
					} else {
						Session::flash('msj', 'Datos ingresados no están registrados. Por favor regístrese para acceder al contenido.');
						Session::flash('msj_fallido', 'Datos ingresados no están registrados. Por favor regístrese para acceder al contenido.');
						return Redirect::to('/');
					}
			} else {
				Session::flash('msj', 'Demuestre que usted no es un robot.');
				Session::flash('msj_fallido', 'Demuestre que usted no es un robot.');
				return Redirect::to('/');
			}
		}
	
	public function logout()
		{
			Auth::user()->logout();
			Auth::admin()->logout();
			return Redirect::to('/');
		}

}
