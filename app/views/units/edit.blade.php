@if (Auth::user()->check())
	{{Redirect::route('admin.index',['admin' => $admin])}}
@else
	@extends('master')

	@section('content')
		<h1>Editar Unidad.</h1>
		{{HTML::script('ckeditor/ckeditor.js')}}
		{{Form::model($unit, ['route' => ['admin.units.update', $admin, $unit->id], 'method' => 'PATCH'])}}
			{{Form::label('name', 'Nombre de la Unidad:')}}
			{{Form::input('name', 'name')}}
			{{Form::label('content', 'Descripcion de la Unidad:')}}
			{{Form::textarea('content',null, ['id' => 'contenido'])}}
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