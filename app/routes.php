<?php
$units = Unit::all();
View::share('units', $units);
Route::get('/', ['as' => 'home', function(){
	if (Auth::user()->check()){
		$user = Auth::user()->get()->name;
		return Redirect::route('admin.index', ['user' => $user]);
	} elseif (Auth::admin()->check()) {
		$admin = Auth::admin()->get()->name;
		return Redirect::route('admin.index', ['admin' => $admin]);
	}
		return View::make('login');
}]);
Route::get('login', function(){
	if (Auth::user()->check()){
		$user = Auth::user()->get()->name;
		return Redirect::route('admin.index', ['user' => $user]);
	} elseif (Auth::admin()->check()) {
		$admin = Auth::admin()->get()->name;
		return Redirect::route('admin.index', ['admin' => $admin]);
	}
	return View::make('login');
});
Route::post('/', ['as' => 'user.login', 'uses' => 'UsersController@login']);
Route::get('logout', ['as' => 'user.logout', 'uses' => 'UsersController@logout']);
Route::get('users/create', ['as' => 'users.create', 'uses' => 'UsersController@create']);
Route::post('users', ['as' => 'users.store', 'uses' => 'UsersController@store']);
Route::get('admin/{admin}', ['as' => 'admin.index', 'uses' => 'AdminsController@index']);
Route::resource('admin.users', 'UsersController', ['except' => ['edit', 'update']]);
Route::resource('admin.units', 'UnitsController');
Route::resource('admin.subjects', 'SubjectsController', ['except' => 'create']);
Route::get('admin/{admin}/subjects/{subject}/create', ['as' => 'admin.subjects.create', 'uses' => 'SubjectsController@create']);
Route::get('admin/{admin}/db_backup', ['as' => 'admin.db_backup', 'uses' => 'AdminsController@db_backup']);
Route::get('admin/{admin}/db_restore', ['as' => 'admin.db_restore', 'uses' => 'AdminsController@db_restore']);
Route::get('admin/{admin}/help', ['as' => 'admin.help', 'uses' => 'AdminsController@help']);
Route::get('admin/{admin}/transactions', ['as' => 'admin.transactions', 'uses' => 'AdminsController@transactions']);
Route::get('admin/{admin}/delete_transactions', ['as' => 'admin.delete.transactions', 'uses' => 'AdminsController@delete_transactions']);
Route::when('admin*', ['before' => 'auth']);