@extends('emails.layout')

@section('content')
	<p style="text-align:center">
		Tienes entregables por aprobar correspondientes al servicio {{ $_project }} prestado por el asesor {{ $_adviser }}.
	</p>

	@include('emails.calltoaction', ['label' => 'Revisa los entregables aquí', 'action' => "$_url_action", 'color' => $_inst_color])
@stop
