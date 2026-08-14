@extends('emails.layout')
@section('content')
	<p style="text-align:center">
		{{ transtp('mentoring.processRefused', ['requesting' => $_requesting]) }}
	</p>

	@include('emails.calltoaction', ['label' => 'Revisa aquí', 'action' => $_url_action, 'color' => $_inst_color])
@stop
