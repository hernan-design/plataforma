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
		@include('public.landing.institutions.bolivar.header')

		{{-- banner video section --}}
        @include('public.landing.institutions.bolivar.banner')

		 {{-- banner  --}}
		<div id="main-land" class="main-section" data-stellar-offset-parent="true">

			{{-- requisitos --}}
            @include('public.landing.institutions.bolivar.about')
		</div>

		<footer class="footer" id="footer-land">
			{{-- Sitemap footer --}}
			@include('public.landing.sitemap')

			{{-- Social and copyright footer --}}
			@include('public.landing.footer')
		</footer>

	</div>
@stop
