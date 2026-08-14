@extends('emails.layout')

@section('content')
	<p>
		<a href="{{{ $_inst_url.$_url_user_action }}}">{{{ $_name_user_action }}}</a>
		<span>{{{ Lang::get('blog.mail.comment.body') }}}</span>
		<br/><br/>
		<span style="font-style:italic;">"{{ $comment }}"</span>
		<p>
	  		<a href="{{{ $_inst_url.$url_contenido }}}" target="_blank">{{{ Lang::get('blog.mail.comment.view') }}}</a>
		</p>
	</p>
@stop
