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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script>
			$('div.alert').not('.alert-danger').delay(3000).slideUp(300);
		</script>
	</div>
@stop