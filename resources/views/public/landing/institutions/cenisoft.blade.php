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
		@include('public.landing.institutions.cenisoft.header')

		{{-- banner video section --}}
		@include('public.landing.institutions.cenisoft.banner')

		{{-- banner  --}}
		<div id="main-land" class="main-section" data-stellar-offset-parent="true">

			{{-- requisitos --}}
			@include('public.landing.institutions.cenisoft.services')
			@include('public.landing.institutions.cenisoft.us')
			@include('public.landing.institutions.cenisoft.events')
			@include('public.landing.institutions.cenisoft.news')
		</div>

		<footer class="footer" id="footer-land">
			{{-- Sitemap footer --}}
			@include('public.landing.institutions.cenisoft.partners')
		</footer>

	</div>
@stop
