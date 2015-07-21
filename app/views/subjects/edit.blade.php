@if (Auth::user()->check())
	{{Redirect::route('admin.index',['admin' => $admin])}}
@else
	@extends('master')

	@section('content')
		<h1>Editar Objetivo.</h1>
		{{HTML::script('ckeditor/ckeditor.js')}}
		{{Form::model($subject, ['route' => ['admin.subjects.update', $admin, $subject->id], 'method' => 'PATCH'])}}
			{{Form::label('name', 'Nombre del Tema:')}}
			{{Form::input('name', 'name')}}
			{{Form::label('content', 'Descripcion del Tema:')}}
			{{Form::textarea('content',null, ['id' => 'contenido'])}}
			{{Form::label('video', 'Video de Apoyo:')}}
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