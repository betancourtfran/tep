<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Tutorial Educativo</title>
	{{-- incluye todos los estilos y scripts --}}
	{{HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css')}}
	{{HTML::style('css/style.css')}}
	{{HTML::style('jquery/jquery-ui.min.css')}}
	{{HTML::script('ckeditor/ckeditor.js')}}
	{{HTML::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js')}}
	{{HTML::script('https://www.google.com/recaptcha/api.js')}}
	{{HTML::script('jquery/jquery-2.1.4.min.js')}}
	{{HTML::script('jquery/jquery-ui.min.js')}}
</head>
<body>
	<div id="wrapper">
		<nav id="nav" class="navbar navbar-default">
			<div class="container-fluid">
			@if (Auth::admin()->check()) {{-- Si el usuario es administrador --}}
				<h1>Bienvenido {{ $admin = Auth::admin()->get()->name }}, al TEP</h1>
				<div id="logout">
					<button type="button" class="btn btn-danger">{{HTML::linkRoute('user.logout', 'Cerrar sesión')}}</button>
				</div>
				<div id="ayuda">
					<button type="button" class="btn btn-primary">{{HTML::linkRoute('admin.help', 'Ayuda', [$admin])}}</button>
				</div>
			@elseif (Auth::user()->check()) {{-- Si el usuario es estudiante --}}
			<h1>Bienvenido {{ $user = Auth::user()->get()->name }}, al TEP</h1>
				<div id="logout">
					<button type="button" class="btn btn-danger">{{HTML::linkRoute('user.logout', 'Cerrar sesión')}}</button>
				</div>
				<div id="ayuda">
					<button type="button" class="btn btn-primary">{{HTML::linkRoute('admin.help', 'Ayuda', [$user])}}</button>
				</div>
			@else {{-- De no haber ingresado al sistema --}}
				<h1>Bienvenidos al TEP</h1>			
			@endif
			</div>
		</nav>
		@if (Auth::admin()->check() || Auth::user()->check()) {{-- Si el administrador o usuarios son autenticados --}}
			<aside id="sidebar">
				{{-- @if (Auth::admin()->check() || Auth::user()->check()) --}}
					@if ($units->count())
						<ul>
							@foreach ($units as $unit)
								<button type"button" class="btn btn-primary btn-lg btn-info enfasis">{{HTML::linkRoute('admin.units.show', $unit->name, [$admin, $unit->name])}}</button>
								@if ($unit->subjects)
									<ul>
										@foreach ($unit->subjects as $subject)
											<li class="enfasis"><h4>{{HTML::linkRoute('admin.subjects.show', $subject->name, [$admin, $subject->name])}}</h4></li>
										@endforeach
										@if (Auth::admin()->check())
											<li>
												{{HTML::linkRoute('admin.subjects.create', '+', [$admin, $unit->name], ['class' => 'btn btn-success', 'title' => 'Crear Objetivo'])}}
											</li>
										@endif
									</ul>
								@endif
							@endforeach
						</ul>
						<hr>
					@else
						<h1>No hay unidades creadas.</h1>
					@endif
					@if (Auth::admin()->check())
						<ul>
							<button type"button" class="btn btn-primary btn-lg btn-info enfasis">
								{{HTML::linkRoute('admin.users.index', 'Estudiantes', [$admin])}}
							</button>
							<button type"button" class="btn btn-primary btn-lg btn-info enfasis">
								{{HTML::linkRoute('admin.units.create', 'Crear Unidad', [$admin])}}
							</button>
							<button type"button" class="btn btn-primary btn-lg btn-info enfasis">
								{{HTML::linkRoute('admin.db_backup', 'Respaldar Datos', [$admin])}}
							</button>
							<button type"button" class="btn btn-primary btn-lg btn-info enfasis">
								{{HTML::linkRoute('admin.db_restore', 'Restaurar Datos', [$admin])}}
							</button>
							<button type"button" class="btn btn-primary btn-lg btn-info enfasis">
								{{HTML::linkRoute('admin.transactions', 'Registro Acciones', [$admin])}}
							</button>
						</ul>
					@endif
				{{-- @endif --}}
			</aside>
		@endif
		<div id="content" {{Auth::admin()->check() || Auth::user()->check() ? 'class = half-width' : '' }}>
			@if (Session::has('msj'))
				<div class="alert alert-success {{Session::has('msj_fallido') ? 'alert-danger' : ''}} ">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					{{Session::get('msj')}}
				</div>
			@endif
			@yield('content')
		</div>
	</div>
	<script>
		$('div.alert').not('.alert-danger').delay(5000).slideUp(300);
	</script>
</body>
</html>
