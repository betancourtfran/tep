@if (Auth::user()->check())
	{{Redirect::route('admin.index',['admin' => $admin])}}
@else
	@extends('master')

	@section('content')

		{{HTML::script('ckeditor/ckeditor.js')}}
		{{Form::open(array('route' => ['admin.units.store', $admin]))}}
			<h1>Crear Unidad.</h1>
			<p>Todos los campos son obligatorios.</p>
			{{Form::label('name', 'Nombre de la Unidad:')}}
			{{Form::input('name', 'name')}}
			{{$errors->first('name', '<span class= "alert alert-danger">El nombre de la unidad es requerido.</span>')}}
			{{Form::label('content', 'Descripción de la Unidad:')}}
			{{Form::textarea('content',null, ['id' => 'contenido'])}}
			{{$errors->first('content', '<span class= "alert alert-danger">La descripción de la unidad es requerida.</span>')}}
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