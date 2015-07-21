@if (Auth::user()->check())
	{{Redirect::route('admin.index',['admin' => $admin])}}
@else
	@extends('master')

	@section('content')

			<h1>Crear Objetivo.</h1>
			{{Form::open(['route' => ['admin.subjects.store', $admin]])}}
			<p>Los campos con (*) son obligatorios.</p>
			{{Form::hidden('unit_id', $unit)}}
			{{Form::label('name', 'Nombre del Objetivo *')}}
			{{Form::input('name', 'name')}}
			{{$errors->first('name', '<span class= "alert alert-danger">El nombre del objetivo es requerido.</span>')}}
			{{Form::label('content', 'Descripción del Objetivo *')}}
			{{Form::textarea('content',null, ['id' => 'contenido'])}}
			{{$errors->first('content', '<span class= "alert alert-danger">La descripción del objetivo es requerida.</span>')}}
			{{Form::label('video', 'Video de Apoyo')}}
			{{Form::input('video', 'video')}}
			<div>
				{{Form::submit('Guardar', ['class' => 'btn btn-success'])}}
				{{HTML::linkRoute('admin.index', 'Cancelar', [$admin], ['class' => 'btn btn-danger'])}}
			</div>
		{{Form::close()}}
		<script>
			CKEDITOR.replace('contenido');
		</script>
	@stop
@endif