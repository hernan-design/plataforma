@extends('layout.core.layout')

@section('content')

	<section id="notification-wrapper">

		<section id="notification-content" class="notification-content">
			{{-- Notification dinamic content  --}}
			@yield('notification.content')
		</section>

	</section>
@stop
