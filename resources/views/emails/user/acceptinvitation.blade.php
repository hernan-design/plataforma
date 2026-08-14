@extends('emails.layout')

@section('content')
	<div>
		<p><span>{{{ Lang::get('user.mail.welcome') }}}</span></p>
		<p align="justify"><span>{!! $change_password !!}</span></p>
		<p style="text-align:center">
			<a href="{{ $_inst_url }}/password/remind" target="_blank" 
				style="display:inline-block; background-color:{{ $_inst_color }}; color:#FFFFFF; padding:15px 10px; text-align:center; text-decoration:none">
				{{{ Lang::get('reminders.change') }}}
			</a>
		</p>
	</div>
@stop
