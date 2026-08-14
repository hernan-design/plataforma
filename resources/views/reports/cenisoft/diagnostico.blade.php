@extends('reports.layout', ['title' => $title, 'type' => 'PDF'])
@section('content')

		<center>
			<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/cenisoft/Logo+SENA.png" style="width: 10%">
			<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/cenisoft/logo_sennova_ok_571a3aec16831.png" class="img-log-extra">
			<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/cenisoft/CPC.png" class="img-log-extra">
			<img src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/institutions/cenisoft/Logo+Fedesoft+Alta.png" class="img-log-extra">
		</center>

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
	<h2 class="center">{{ $survey->nombre_encuesta }}</h2>
	@include('reports.form.form', compact('survey', 'groupings', 'questions', 'subquestions'))
@stop
