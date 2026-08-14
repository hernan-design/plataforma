@extends('emails.layout')
@section('content')
	<p style="text-align:center">
		{{{ transtp('mentoring.emails.notification', ['mentored' => $_requesting, 'entity' => $_entity]) }}}
	</p>
	<p style="text-align:center">{{ $_desc }} </p>
	<p style="text-align:center">Si deseas aceptar esta solicitud has click en el siguiente botón.</p>

	@include('emails.calltoaction', ['label' => 'Aceptar solicitud', 'action' => $_url_action, 'color' => $_inst_color])

	<p style="text-align:center">Si deseas rechazar esta solicitud has click en el siguiente botón. </p>

	@include('emails.calltoaction', ['label' => 'Rechazar solicitud', 'action' => $_url_action_refuse, 'color' => $_inst_color])
@stop
