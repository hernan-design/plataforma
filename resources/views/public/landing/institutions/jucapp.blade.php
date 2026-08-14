@extends('layout.landing.layout')

@section('content')

	<div id="wrapper-land" class="login-alert-display wrapper-{{ $institution->slug_institucion }}">
		{{-- Alerts --}}
		<div data-alert class="alert-box-tp">
			<i class="icon-alert"></i>
			<span></span>
			<a href="#" class="">&times;</a>
		</div>

		{{-- Header --}}
		@include('public.landing.institutions.jucapp.header')

		{{-- banner video section --}}
		@include('public.landing.institutions.jucapp.banner')

	</div>
@stop
