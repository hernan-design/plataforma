@extends('emails.layout')

@section('content')
<p>El registro en la convocatoria <b>{{$program_name}}</b> ha finalizado exitosamente.</p>
<b>Sus datos de aplicación son:</b>
<ul>
    <li>Número de aplicación: {{$program_aplication_number}}</li>
    <li>Fecha de aplicación: {{$program_aplication_date}}</li>
	<li>Proyecto postulado: {{$nombre_aplicante}}</li>
</ul>
@stop
