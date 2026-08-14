@extends('emails.layout')

@section('content')
	<p style="text-align:center">
		<a href="{{{ $_inst_url.$_url_user_action }}}">{{{ $_name_user_action }}}</a>
		<span>{{{ Lang::get('discussion.mail.comment.body') }}} <a href="{{{ $_inst_url.$url_discusion }}}" target="_blank">{{{ Lang::get('discussion.mail.comment.view') }}}</a></span>
	<br/><br/>
	<span style="font-style:italic;">"{{ $comment }}"</span>
	</p>
@stop
