@if (Auth::user()->check())
	{{Redirect::route('admin.index',['admin' => $admin])}}
@else
	@extends('master')

	@section('content')
		<h1>Lista de estudiantes registrados</h1>
		@if ($users->count())
			<ul>
				@foreach ($users as $user)
					<li class="enfasis">{{HTML::linkRoute('admin.users.show', $user->name." ".$user->last_name, [$admin, $user->name])}}</li>
				@endforeach
			</ul>
		@else
			<h1>No hay estudiantes registrados</h1>
		@endif

		{{HTML::linkRoute('admin.users.create', 'Registrar Estudiante', [$admin], ['class' => 'btn btn-default'])}}
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script>
			$('div.alert').delay(3000).slideUp(300);
		</script>
	@stop
@endif