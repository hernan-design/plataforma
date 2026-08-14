@extends('emails.layout')

@section('content')
<p>El registro en <b>{{$program_name}}</b> ha finalizado exitosamente.</p>
<b>Los datos ingresados son:</b>
<ul>
    <li>Número de aplicación: {{$program_aplication_number}}</li>
    <li>Fecha de aplicación: {{$program_aplication_date}}</li>
	<li>Aplicante: {{$nombre_aplicante}}</li>
</ul>
@stop
