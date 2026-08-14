@extends('emails.layout')

@section('content')
	<p style="text-align:center">
		El empresario {{ $_purchaser }} finalizó el servicio {{ $_project }} del asesor {{ $_seller }}.
	</p>

	@include('emails.calltoaction', ['label' => 'Revisa los entregables aquí', 'action' => "$_url_action", 'color' => $_inst_color])
@stop
