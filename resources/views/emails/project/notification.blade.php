@extends('emails.layout')

@section('content')
	<p>
		@if($owner)
			<a href="{{{ $_inst_url.$_url_user_action }}}">{{{ $_name_user_action }}}</a>
			<span>{{{ Lang::get('project.mail.comment.body.owner') }}}</span>
			<br/><br/>
			<span style="font-style:italic;">"{!! $comment !!}"</span>

			<p>
		  		<a href="{{{ $_inst_url.$url_proyecto }}}" target="_blank">{{{ Lang::get('project.mail.comment.view') }}}</a>
			</p>
		@else
			<a href="{{{ $_inst_url.$_url_user_action }}}">{{{ $_name_user_action }}}</a>
			<span>{{{ Lang::get('project.mail.comment.body') }}}</span>
			<br/><br/>
			<span style="font-style:italic;">"{!! $comment !!}"</span>
			<p>
		  		<a href="{{{ $_inst_url.$url_proyecto }}}" target="_blank">{{{ Lang::get('project.mail.comment.view') }}}</a>
			</p>
		@endif
	</p>
@stop
