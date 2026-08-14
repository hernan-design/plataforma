@extends('emails.layout')
@section('content')
	<p style="text-align:center">
		Información de la sesión finalizada.
	</p>
	<ul>
		<li># Mentoría: <b>{{ $_codigo_asesoria }}</b></li>
		<li># Sesión: <b>{{ $_codigo_mentoria }}</b></li>
		<li>Etapa: <b>{{ $_fase }}</b></li>
		<li>Nombre mentor: <b>{{ $_nombre_usuario_mentor }}</b></li>
		<li>Nombre emprendedor: <b>{{ $_nombre_usuario_emprendedor }}</b></li>
		<li>Nombre emprendimiento: <b>{{ $_nombre_emprendimiento }}</b></li>

		<li>Fecha de aceptación de la sesión: <b>{{ $_fecha_aceptacion }}</b></li>
	</ul>
	<p>Categorías sugeridas:</p>
	<ul>
		@foreach ($_categorias_sugeridas as $categoria)
			<li>{{ $categoria }}</li>
		@endforeach
	</ul>
	<p style="text-align: center">
		<a
			href="https://admincvs.rutan.co/convocatoria/634"
			target="_blank"
			type="button"
			class="button small sky-blue btn-shadow radius expand btn-clean-margin"
		>
			ASIGNAR VOUCHER
		</a>
	</p>
@stop
