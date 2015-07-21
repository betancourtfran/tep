@extends('master')

@section('content')

	<div id="tabs">
		<ul>
			<li><a href="#registrarse"><h4>Registro</h4></a></li>
			<li><a href="#ingresar"><h4>Ingreso</h4></a></li>
			<li><a href="#objetivo"><h4>Objetivo</h4></a></li>
			<li><a href="#unidad"><h4>Unidad</h4></a></li>
			@if(Auth::admin()->check())
				<li><a href="#cargar_unidad"><h4>Cargar Unidad</h4></a></li>
				<li><a href="#cargar_objetivo"><h4>Cargar Objetivo</h4></a></li>
			@endif
		</ul>
			<div id="registrarse"><p>El estudiante puede registrarse en el TEP ingresando los datos solicitados. Entre esos datos, se encuentra un email y contraseña, los cuales son necesarios para poder ingresar al TEP despues de haber realizado su registro.</p></div>
			<div id="ingresar"><p></p>El estudiante puede ingresar al TEP con el email y contraseña que proporcionó en el momento de su registro. Luego de haber ingresado, será capaz de poder visualizar todos los objetivos y unidades cargadas por el profesor (Administrador).</p></div>
			<div id="unidad"><p>Las "Unidades" son unidades de programación de enseñanza con un tiempo determinado, estas están compuestas por "Objetivos", los cuales son todo el contenido necesario para la enseñanza de un tema en específico.</p></div>
			<div id="objetivo">Los "Objetivos" son aquellos que componen una "Unidad", sin la exitencia de una "Unidad" entonces no puede haber "Objetivos".</p></div>
			@if(Auth::admin()->check())
				<div id="cargar_unidad"><p>Luego de haber ingresado al TEP, el administrador puede realizar el registro de alguna unidad mediante la opción “Crear Unidad”. Luego del administrador haber seleccionado la opción “Crear Unidad”, es mostrado un formulario donde puede llenar los datos necesarios para crear la unidad.</p></div>
				<div id="cargar_objetivo"><p>El administrador tambien cuenta con la opción de cargar un objetivo a una unidad previamente creada. Tras haber seleccionado la opción de crear un objetivo, es mostrado un formulario al administrador, el cual puede llenar con los datos necesarios para crear un objetivo dentro de la unidad correspondiente. Luego selecciona la opción “Guardar” para cargar el objetivo. El campo “Video de Apoyo” es opcional, este sirve para insertar un video dentro del objetivo y debe ser llenado con un enlace hacia el video alojado en otro sitio web de la siguiente manera:</p>
					<p>Desde YouTube:</p>
					<ul>
						<li>1. El administrador debe buscar el video que desea agregar al objetivo.</li>
						<li>2. Luego que el video es mostrado y listo para su reproducción, el administrador debe seleccionar la opción “Share” o su equivalente en español “Compartir”.</li>
						<li>3. Después se muestran nuevas opciones, entre las cuales el administrador debe seleccionar “Embed” o su equivalente en español “Insertar vínculo” y copiar el código que aparece dentro del campo de texto que muestra esta opción.</li>
						<li>4. Ese código es el que el administrador debe pegar dentro del campo “Video de Apoyo” en el TEP para asi poder agregar un video al objetivo.</li>
					</ul>
					<p>Desde Vimeo:</p>
					<ul>
						<li>1. El administrador debe buscar el video que desea agregar al objetivo.</li>
						<li>2. Luego que el video es mostrado y listo para su reproducción, el administrador debe seleccionar la opción “Share” o su equivalente en español “Compartir”.</li>
						<li>3. Después se muestra un cuadro con distintas opciones para compartir el video, entre las cuales el administrador debe seleccionar “Embed” o su equivalente en español “Insertar” y copiar el código que aparece dentro del campo de texto que muestra esta opción.</li>
						<li>4. Ese código es el que el administrador debe pegar dentro del campo “Video de Apoyo” en el TEP para asi poder agregar un video al objetivo.</li>
					</ul>
					<p>Nota: La opción “Show options” o su equivalente en español “Mostrar opciones” despliega una lista de opciones para modificar las propiedades del video como el tamaño, color de ciertos elementos, autor, entre otros.</p>
				</div>
				@endif
	</div>

<script>
	$(function(){
		$("#tabs").tabs();
	});
</script>

@stop