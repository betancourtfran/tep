@extends('master')

@section('content')
	@if ($handle)
		<div id="log">
			<h1>Registro de Acciones</h1>
			<ul>
				 @while(!feof($handle))
						<?php $entry = fgets($handle); ?>
						@if (trim($entry) != "") 
							{{"<li>{$entry}</li>";}}
						@endif
				@endwhile
				<?php fclose($handle); ?>
			</ul>			
		</div>
				<button type="button" class="btn btn-danger">{{HTML::linkAction('AdminsController@delete_transactions', 'Eliminar acciones registradas', [$admin])}}
				</button>
	@endif
	
@stop