@extends('layout.landing.layout')

@section('content')

	<div id="wrapper-land" class="login-alert-display wrapper-{{ $institution->slug_institucion }}">
		{{-- Alerts --}}
		<div data-alert class="alert-box-tp">
			<i class="icon-alert"></i>
			<span></span>
			<a href="#" class="close">&times;</a>
		</div>

		{{-- Header --}}
		@include('public.landing.institutions.sja.header')

		{{-- banner video section --}}
		@include('public.landing.institutions.sja.banner')

		{{-- banner  --}}
		<div id="main-land" class="main-section" data-stellar-offset-parent="true">

			{{-- requisitos --}}
			@include('public.landing.institutions.sja.campus')
			@include('public.landing.institutions.sja.teachers')
		</div>

		<footer class="footer" id="footer-land">
			{{-- Sitemap footer --}}
			@include('public.landing.institutions.sja.footer')
		</footer>

	</div>
@stop
