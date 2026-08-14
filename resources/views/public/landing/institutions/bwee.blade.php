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
		@include('public.landing.institutions.bwee.header')

		{{-- banner --}}
		@include('public.landing.institutions.bwee.banner')


		<div id="main-land" class="main-section" data-stellar-offset-parent="true">

			{{-- requisitos --}}
			@include('public.landing.institutions.bwee.section1')
			@include('public.landing.institutions.bwee.section2')
		</div>

		<footer class="footer" id="footer-land">

			{{-- Social and copyright footer --}}
			@include('public.landing.institutions.bwee.footer')
		</footer>

	</div>
@stop
