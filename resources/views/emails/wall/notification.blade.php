@extends('emails.layout')

@section('content')
	<p>
		@if($owner)
			<a href="{{{ $_inst_url.$_url_user_action }}}">{{{ $_name_user_action }}}</a>
			<span>{{{ Lang::get('wall.mail.body.owner') }}}</span>
			<br/><br/>
			<span style="font-style:italic;">"{!! $comment !!}"</span>
		@else
			<a href="{{{ $_inst_url.$_url_user_action }}}">{{{ $_name_user_action }}}</a>
			<span>{{{ Lang::get('wall.mail.body') }}}</span>
			<br/><br/>
			<span style="font-style:italic;">"{!! $comment !!}"</span>
		@endif
	</p>
@stop
