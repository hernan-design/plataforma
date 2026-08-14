@extends('emails.layout')

@section('content')

	<p>{{{ trans('passwords.mail.body') }}}</p>
	
	@include('emails.calltoaction', ['label' => trans('passwords.mail.view'), 'action' => "$_inst_url/password/reset/$token?email=$email", 'color' => $_inst_color])                
	<p>{!! trans('passwords.mail.alert') !!}</p>

@stop

