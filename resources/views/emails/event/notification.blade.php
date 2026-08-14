@extends('emails.layout')

@section('content')
 
	<p style="text-align:center">
		<span>{{{ Lang::get('event.mail.participate.body', ['institucion'=>$_inst_name,'event' => $_event_name]) }}}</span>
	</p>
	<p style="text-align:center">
		<a href="{{$_url_action}}" target="_blank"
			style="display:inline-block; background-color:{{ $_inst_color }}; color:#FFFFFF; padding:15px 10px; text-align:center; text-decoration:none">
			Ver Evento
		</a>
	</p>

	<p><b>Fecha:</b> {{ $_event_date }}</p>
	<p><b>Lugar:</b> {{ $_event_place }}</p>
	<p><b>Hora:</b> {{ $_event_hour }}</p>
		
	@if ($_url_meet)
		<p style="text-align:center">
			{{ transtp('event.textMeet') }}<br><br>
			<a href="{{$_url_meet}}" target="_blank"
			style="display:inline-block; background-color:{{ $_inst_color }}; color:#FFFFFF; padding:15px 10px; text-align:center; text-decoration:none">
				Ir a la reunion
			</a>
		</p>
	@endif
 
@stop
