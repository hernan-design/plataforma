@extends('emails.layout')

@section('content')
	<p style="text-align:center">
		{{ $_seller }} ha generado un acuerdo de negociación por el servicio {{ $_product }}.
	</p>

	@include('emails.calltoaction', ['label' => 'Revísalo aquí', 'action' => $_url_action, 'color' => $_inst_color])
@stop
