@if (Auth::user()->check())
	{{Redirect::route('admin.index',['admin' => $admin])}}
@else
	@extends('master')

	@section('content')
		<h1>Registro de Estudiante.</h1>
		@if (Auth::admin()->check())
			{{Form::open(['route' => ['admin.users.store', $admin]])}}
			<p>Todos los campos son obligatorios.</p>
		@else
			{{Form::open(['route' => ['users.store', $admin]])}}
			<p>Todos los campos son obligatorios.</p>
		@endif
			{{Form::label('name', 'Nombre:')}}
			{{Form::text('name', null)}}
			{{$errors->first('name', '<span class= "alert alert-danger">El nombre es requerido.</span>')}}
			
			{{Form::label('last_name', 'Apellido:')}}
			{{Form::text('last_name', null, ['required'])}}
			{{$errors->first('last_name', '<span class= "alert alert-danger">:message</span>')}}
			
			{{Form::label('email', 'Email:')}}
			{{Form::email('email', null, ['required'])}}
			{{$errors->first('email', '<span class= "alert alert-danger">:message</span>')}}
			
			{{Form::label('password', 'Contraseña:')}}
			{{Form::password('password', null, ['required'])}}
			{{$errors->first('password', '<span class= "alert alert-danger">La contraseña es requerida.</span>')}}
			{{Form::captcha()}}
			{{$errors->first('g-recaptcha-response', '<span class= "alert alert-danger">Demuestre que usted no es un robot.</span>')}}
			<div>
				{{Form::submit('Registrar', ['class' => 'btn btn-success'])}}
				@if (Auth::admin()->check())
					{{HTML::linkRoute('admin.users.index', 'Cancelar', [$admin], ['class' => 'btn btn-danger'])}}
				@else
					{{HTML::linkRoute('home', 'Cancelar',null, ['class' => 'btn btn-danger'])}}			
				@endif
			</div>
		{{Form::close()}}
	@stop
@endif