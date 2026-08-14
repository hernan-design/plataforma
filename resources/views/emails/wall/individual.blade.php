@extends('emails.layout')

@section('content')
	<p>	
		<span>{{ $_subject }}</span>
		<br/><br/>
		<span style="font-style:italic;">"{!! $comment !!}"</span>
	</p>
	<p>
  		<a href="{{{ $_inst_url.$url_wall }}}" target="_blank">{{{ Lang::get('wall.mail.individual.view') }}}</a>
	</p>
@stop
