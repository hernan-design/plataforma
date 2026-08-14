@extends('emails.layout')

@section('content')
	<p align="justify">
		<span>{!! transtp('calls.diagnostic') !!}</span>
		@include('emails.calltoaction', ['label' => 'Descarga tu Diagnóstico', 'action' => "$_url_action", 'color' => $_inst_color])
	</p>
@stop
