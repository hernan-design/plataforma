@extends('emails.layout')

@section('content')
	<p>
		<a href="{{{ $_inst_url.$_url_user_action }}}">{{{ $_name_user_action }}}</a>
		<span>{{{ Lang::get('mentoring.mail.comment.body') }}}</span>
		<br/><br/>
		<span style="font-style:italic;">"{{ $comment }}"</span>
		<p>
	  		<a href="{{{ $_inst_url.$url_discusion }}}" target="_blank">{{{ Lang::get('mentoring.mail.comment.view') }}}</a>
		</p>
	</p>
@stop
