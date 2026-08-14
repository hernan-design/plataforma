@extends('emails.layout')

@section('content')
	<p style="text-align:center">
		Un empresario realizó una oferta por tú servicio.
	</p>

	@include('emails.calltoaction', ['label' => 'Revisa su oferta aquí', 'action' => "$_url_action", 'color' => $_inst_color])
@stop
