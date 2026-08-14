@extends('emails.layout')

@section('content')
	<p>
		<span>{{{ Lang::get('mentoring.mail.mentorconfirm.body.rutan', ['number_session' => $_sessionID])}}}
		<a href="{{{ $_inst_url.$_url_user_action }}}">{{{ $_name_user_action }}}</a>
		<br>
		<br>
			{{{ Lang::get('mentoring.mail.body.time.start') }}}
			{{{$date_start}}}
		<br>
		<br>
			{{{ Lang::get('mentoring.mail.body.time.end') }}}
			{{{$date_end}}}
		<br>
		<br>
		{{{ Lang::get('mentoring.mail.body.site') }}}
		<a href="{{{$_lugar_evento}}}" target="_blank" class="text-skyblue upper-text text-lg normal-text">Da click aquí</a>
		<br>
		<br>
			{{{ Lang::get('mentoring.mail.doubts.contact')}}}
		<br>
		<p style="text-align:center">
			rutan@rutan.com
		</p>
	</p>
@stop
