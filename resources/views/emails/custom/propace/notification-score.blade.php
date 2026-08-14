@extends('emails.layout')

@section('content')
	<p align="justify">
		<p>Gracias por hacer parte del programa de formación a cuidadores.</p>
		<p>Usted ha finalizado la evaluación <b> {{ $_survey }} </b> y obtuvo una puntuación total de <b> {{ $_score }} </b> </p>
	</p>
@stop
