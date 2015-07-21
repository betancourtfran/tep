@extends('master')
@section('content')
	<h1>{{$unit->name}}</h1>
	{{$unit->content}}
	<br>
	{{Form::open(['method' => 'DELETE', 'route' => ['admin.units.destroy', $admin, $unit->id]])}}
	@if (Auth::admin()->check())
		{{HTML::linkRoute('admin.units.edit', 'Editar Unidad', [$admin, 'name' => $unit->name], ['class' => 'btn btn-default'])}}
		{{Form::submit('Eliminar Unidad', ['class' => 'btn btn-danger', 'onclick' => "return confirm('¿Está seguro de querer eliminar esta unidad y todos sus objetivos?');"])}}
	@endif
	{{Form::close()}}
@stop