@extends('emails.layout')

@section('content')
	<p style="text-align:justify">
		Se agendó una reunión, puedes ingresar mediante el siguiente link:
	</p>

	@include('emails.calltoaction', ['label' => (isset($label_action) ? $label_action : 'Conectarse'), 'action' => "$_url", 'color' => $_inst_color])
@stop
