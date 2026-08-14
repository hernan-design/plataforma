@extends('emails.layout')

@section('content')
	<div>
		<p style="text-align:center">Bienvenido</p>
		<p><span>{{{ trans('user.mail.welcome') }}}</span></p>
		<p align="justify"><span>{!! $body !!}</span></p>

		@include('emails.calltoaction', ['label' => trans('app.confirm.mail.confirm'), 'action' => $_inst_url.$_url_action, 'color' => $_inst_color])
	</div>
@stop
