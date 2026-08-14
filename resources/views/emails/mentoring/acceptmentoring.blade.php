@extends('emails.layout')
@section('content')
	<p style="text-align:center">

		<!-- {{ transtp('mentoring.processAccept', ['requesting' => $_requesting, 'tituloMentoria' => $_title_mentoring]) }} -->
		El emprendedor <b>{{ $_requesting }}</b> aceptó lo realizado en la sesión 
		<b>{{ $_title_mentoring }}</b> Cod. <b>{{ $_sessionID }}</b>.
	</p>
	<ul>
		<li>Fecha y hora programada para la sesión: <b>{{ $_dateAndHour }}</b></li>
		<li>Duracion registrada por el mentor: <b>{{ $_duration_mentoring }}</b></li>
		<li>Descripcion de la sesión: <b>{{ $_description_mentoring }}</b></li>
		<li>Codigo de la sesión: <b>#{{ $_sessionID }}</b></li>
	</ul>

	@include('emails.calltoaction', ['label' => 'Ir a procesos de mentoria', 'action' => $_url_action, 'color' => $_inst_color])
@stop
