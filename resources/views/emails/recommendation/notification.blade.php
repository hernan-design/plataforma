@extends('emails.layout')

@section('content')
	<p align="center">
		<span>{{{ $_name_user }}} te ha recomendado este</span>
		<a href="{{{ $url_recomendacion }}}">Mentor</a>
		<br/><br/>
		<p align="center">
	  		{{{ $_message }}}
		</p>
	</p>
@stop
