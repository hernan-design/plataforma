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
	@include('public.landing.institutions.innpulsa.header')

	{{-- main land  --}}
	<div id="main-land" class="main-section" data-stellar-offset-parent="true">

	{{-- Footer --}}
	@include('public.landing.institutions.innpulsa.main')

	{{-- Footer --}}
	@include('public.landing.institutions.innpulsa.footer')

</div>
@stop
