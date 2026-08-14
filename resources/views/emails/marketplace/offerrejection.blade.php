@extends('emails.layout')

@section('content')
	<p style="text-align:center">
		{{ $_seller }} ha rechazado tú oferta por el servicio {{ $_product }}.
	</p>
@stop
