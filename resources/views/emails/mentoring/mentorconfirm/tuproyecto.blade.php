@extends('emails.layout')

@section('content')
	<p>
		<span>{{{ Lang::get('mentoring.mail.mentorconfirm.body', ['number_session' => $_sessionID])}}}
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
			{{{ Lang::get('mentoring.mail.body.time.zone') }}}
		<br>
		<br>
		{{{ Lang::get('mentoring.mail.body.site') }}}
		<a href="{{{$_lugar_evento}}}" target="_blank" class="text-skyblue upper-text text-lg normal-text">Da click aquí</a>
		<br>
		<br>
		{{{ Lang::get('mentoring.mail.doubts.contact') }}}
		<br>
		<br>
		<p style="text-align:justify">
			{{{$_contactEmail}}}
		</p>
		<br>
	</p>
	{{-- @if(isset($_url) && !empty($_url))
		<p style="text-align:justify">
			Se agendó una reunión, puedes ingresar mediante el siguiente link:
		</p>
		@include('emails.calltoaction', ['label' => (isset($label_action) ? $label_action : 'Conectarse'), 'action' => "$_url", 'color' => $_inst_color])
	@endif --}}
@stop
