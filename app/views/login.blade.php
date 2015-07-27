@extends('master')

@section('content')
	<div id="main_image"></div>
	<div id="ingreso">
		<h1>Ingresa</h1>
		{{Form::open(['route' => 'user.login'])}}
			{{Form::label('email', 'Email:')}}
			{{Form::email('email', null, ['required'])}}
			{{Form::label('password', 'Contraseña:')}}
			{{Form::password('password', null, ['required'])}}
			{{Form::captcha()}}
			<div>
				{{Form::submit('Ingresar', ['class' => 'btn btn-default'])}}
				<p>
					¿No estás registrado? Regístrate
					{{HTML::linkRoute('users.create', 'aquí.')}}
				</p>
			</div>
		{{Form::close()}}
	</div>
@stop