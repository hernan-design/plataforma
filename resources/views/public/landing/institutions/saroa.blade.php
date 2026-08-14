@extends('layout.landing.layout')

@section('content')

	<div id="wrapper-land" class="login-alert-display wrapper-sja">
		{{-- Alerts --}}
		<div data-alert class="alert-box-tp">
			<i class="icon-alert"></i>
			<span></span>
			<a href="#" class="close">&times;</a>
		</div>

		{{-- Header --}}
		@include('public.landing.institutions.saroa.header')

		{{-- banner video section --}}
		@include('public.landing.institutions.saroa.banner')

		{{-- banner  --}}
		<div id="main-land" class="main-section" data-stellar-offset-parent="true">

			{{-- requisitos --}}
			@include('public.landing.institutions.saroa.campus')
			@include('public.landing.institutions.saroa.teachers')
		</div>

		<footer class="footer" id="footer-land">
			{{-- Sitemap footer --}}
			@include('public.landing.institutions.saroa.footer')
		</footer>

	</div>
@stop
