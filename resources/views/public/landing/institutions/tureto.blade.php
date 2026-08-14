@extends('layout.landing.layout')
@section('content')
<div id="wrapper-land" class="login-alert-display wrapper-{{ $institution->slug_institucion }}">
    <div data-alert class="alert-box-tp">
		<i class="icon-alert"></i>
		<span></span>
		<a href="#" class="close">&times;</a>
	</div>

	{{-- Header --}}
	@include('public.landing.header')

	@include('public.landing.institutions.tureto.banner')

	{{-- main land  --}}
	<div id="main-land" class="main-section">
		@include('public.landing.institutions.tureto.campus')
		@include('public.landing.institutions.tureto.teachers')
	</div>

	<footer class="footer" id="footer-land">
		{{-- Sitemap footer --}}
		@include('public.landing.institutions.tureto.footer')
	</footer>
</div>
@stop
