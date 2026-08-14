@extends('emails.layout')

@section('content')
	<p>
		@if($owner)
			<span>{{{ Lang::get('forum.mail.body.owner') }}}</span>
		@else
			<a href="{{{ $_inst_url.$_url_user_action }}}">{{{ $_name_user_action }}}</a>
			<span>{{{ Lang::get('forum.mail.body') }}}</span>
		@endif
		<a href="{{{ $_inst_url.$url_foro }}}" target="_blank">{{{ $titulo_foro }}}</a>.
	</p>
	<p>
  		<a href="{{{ $_inst_url.$url_foro }}}" target="_blank">{{{ Lang::get('forum.mail.view') }}}</a>
	</p>
@stop
