@extends('emails.layout')

@section('content')
	<p align="justify">
		<span>{!! transtp('mail.body', ['nombre_convocatoria' => $_nombre_convocatoria]) !!}</span>
	</p>
@stop
