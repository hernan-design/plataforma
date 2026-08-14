@extends('emails.layout')

@section('content')

	<p style="text-align:center">
		<!-- El usuario {{ $_owner_mail }} {{ $_title }}  -->
		{{ transtp('mentoring.emails.discution', ['owner_mail' => $_owner_mail, 'title' => $_title]) }}
	</p>

	@include('emails.calltoaction', ['label' => 'Ver mensaje', 'action' => "$url_discusion", 'color' => $_inst_color])
@stop
