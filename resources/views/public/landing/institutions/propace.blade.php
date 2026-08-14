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
		@include('public.landing.institutions.propace.header')

		{{-- banner video section --}}
		@include('public.landing.institutions.propace.banner')

		{{-- banner  --}}
		<div id="main-land" class="main-section" data-stellar-offset-parent="true">

			{{-- requisitos --}}
			@include('public.landing.institutions.propace.comunity')
			@include('public.landing.institutions.propace.advantage')
			{{--@include('public.landing.institutions.propace.form')--}}
		</div>

		<footer class="footer" id="footer-land">
			{{-- Sitemap footer --}}
			@include('public.landing.institutions.propace.footer')
		</footer>

	</div>
@stop
