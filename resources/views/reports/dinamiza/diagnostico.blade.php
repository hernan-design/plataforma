@extends('reports.layout', ['title' => $title, 'type' => 'PDF'])
@section('content')
	@if(isset($proyect->imagen_usuario) && !is_null($proyect->imagen_usuario) && !empty($proyect->imagen_usuario))
		<center>
			<img src="{{ $proyect->imagen_usuario }}" class="img-user">
		</center>
	@endif
	<p class="justify">{{ $proyect->biografia_usuario }}</p>
	<h3><strong>Industria:</strong> {{ $proyect->nombre_categoria_proyecto }}</h3>
	@if( $proyect->nombre_ciudad != '' )
		<h3>{{ $proyect->nombre_ciudad }}, {{ $proyect->distrito_ciudad }} </h3>
	@endif
	<h2><strong>Creador:</strong></h2>
	<span>{{ $proyect->nombre_founder }}</span><br>
	<span>{{ $proyect->ciudad_founder }}, {{ $proyect->distrito_ciudad_founder }}</span>
	<div class="page_break"></div>
	<h2 class="center">DIAGNÓSTICO</h2>
	<img src="{{ $graph }}" style="width: 710px; height: 300px; border: none">
	<br><br>
	<p class="justify">{!!$report->data_general->texto_respuesta!!}</p>
	<div class="page_break"></div>
	@if (isset($oportunidades) && !empty($oportunidades))
		<h2 class="center">OPORTUNIDADES</h2>
		<h2>Cursos recomendados</h2>
		<p class="justify">Te invitamos a desarrollar los siguientes cursos para que fortalezcas tu negocio en las áreas identificadas en la sección de Diagnóstico.</p>
		<br>
		<table style="width: 100%">
			@foreach ($oportunidades as $value)
				<tr>
					<td>
						<img src="{{ $value->imagen_convocatoria }}" style="width: 180px; height: 130px"></img>
					</td>
					<td>
						<h3>{{ $value->nombre_convocatoria }}</h3>
						@if ($value->descripcion_convocatoria)
							<p class="justify"> {!!$value->descripcion_convocatoria!!} </p>
						@else
							''
						@endif
					</td>
				</tr>
			@endforeach
		</table>
		@else
		<h2 class="center">OPORTUNIDADES</h2>
		<p class="justify">No encontramos ningún programa que coincida con el resultado del diagnostico.</p>
		<br>
	@endif
	<div class="page_break"></div>
	<h2 class="center">{{ $survey->nombre_encuesta }}</h2>
	@include('reports.form.form', compact('survey', 'groupings', 'questions', 'subquestions'))
@stop
