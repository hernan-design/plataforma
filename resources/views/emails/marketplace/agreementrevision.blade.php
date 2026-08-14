@extends('emails.layout')

@section('content')
	<p style="text-align:center">
		El acuerdo de negociación para el servicio {{ $_product }} requiere de tú revisión y aprobación.
	</p>

	@include('emails.calltoaction', ['label' => 'Revísalo aquí', 'action' => $_url_action, 'color' => $_inst_color])
@stop
