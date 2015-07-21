@extends('master')

@section('content')

	<h1>{{$subject->name}}</h1>
	{{$subject->content}}
	@if ($subject->video)
		{{$subject->video}}
	@endif
	@if (Auth::admin()->check())
		{{Form::open(['method' => 'DELETE', 'route' => ['admin.subjects.destroy', $admin, $subject->id]])}}
			{{HTML::linkRoute('admin.subjects.edit', 'Editar Objetivo', [$admin, $subject->name], ['class' => 'btn btn-default'])}}
			{{Form::submit('Eliminar Objetivo', ['class' => 'btn btn-danger', 'onclick' => "return confirm('¿Está seguro de querer eliminar este objetivo?');"])}}
		{{Form::close()}}
	@endif
	<div id="disqus_thread"></div>
	<script type="text/javascript">
	    /* * * CONFIGURATION VARIABLES * * */
	    var disqus_shortname = 'tepiuteb';
	    
	    /* * * DON'T EDIT BELOW THIS LINE * * */
	    (function() {
	        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
	        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
	        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
	    })();
	</script>
@stop