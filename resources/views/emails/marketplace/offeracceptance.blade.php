@extends('emails.layout')

@section('content')
	<p style="text-align:center">
		{{ $_seller }} ha aceptado tú oferta por el servico {{ $_product }}, procede a completar tú compra.
	</p>

	@include('emails.calltoaction', ['label' => 'Completar compra', 'action' => $_url_action, 'color' => $_inst_color])
@stop
