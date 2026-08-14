@extends('emails.layout')

@section('content')
	<p>
		<a href="{{{ $_inst_url.$_url_user_action }}}">{{{ $_name_user_action }}}</a>
		<span>{{{ Lang::get('mentoring.mail.confirm.body') }}}
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
		{{{$_lugar_evento}}}
		<br>
		<br>
			{{{ Lang::get('mentoring.mail.doubts.contact', ['email' => $_contactEmail]) }}}
		<br>
	</p>
	{{-- @if(isset($_url) && !empty($_url))
		<p style="text-align:justify">
			Se agendó una reunión, puedes ingresar mediante el siguiente link:
		</p>
		@include('emails.calltoaction', ['label' => (isset($label_action) ? $label_action : 'Conectarse'), 'action' => "$_url", 'color' => $_inst_color])
	@endif --}}
@stop
