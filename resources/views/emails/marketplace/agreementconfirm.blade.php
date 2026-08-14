@extends('emails.layout')

@section('content')
	<p style="text-align:center">
		Tienes un acuerdo de negociación por revisar.

		@include('emails.calltoaction', ['label' => 'Ver acuerdo', 'action' => $_url_admin_institution, 'color' => $_inst_color])
	</p>
@stop
