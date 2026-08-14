@extends('layout.landing.layout')

@section('content')

	<div id="wrapper-land" class="login-alert-display wrapper-{{ $institution->slug_institucion }}">
		{{-- Alerts --}}
		<div data-alert class="alert-box-tp">
			<i class="icon-alert"></i>
			<span></span>
			<a href="#" class="close">&times;</a>
		</div>
		@include('public.landing.institutions.serviu.header')
		<div id="main-land" class="main-section" data-stellar-offset-parent="true">
			{{-- requisitos --}}
			@include('public.landing.institutions.serviu.home')
		</div>
		<footer class="footer" id="footer-land">
			{{-- Sitemap footer --}}
		</footer>

	</div>
@stop
