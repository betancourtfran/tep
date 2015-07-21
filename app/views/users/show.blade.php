@if (Auth::user()->check())
	{{Redirect::route('admin.index',['admin' => $admin])}}
@else
	@extends('master')

	@section('content')
		
		<h1>{{$user->name." ".$user->last_name}}.</h1>
		<h3>{{$user->email}}</h3>
		<h3>Registrado en el {{$user->created_at}}</h3>
		{{Form::open(['route' => ['admin.users.destroy',$admin, $user->id], 'method' => 'DELETE'])}}
			{{HTML::linkRoute('admin.users.index', 'Cancelar',[$admin], ['class' => 'btn btn-default'])}}
			{{Form::submit('Eliminar Estudiante', ['class' => 'btn btn-danger', 'onclick' => "return confirm('¿Está seguro de querer eliminar este estudiante?');"])}}
		{{Form::close()}}

	@stop
@endif