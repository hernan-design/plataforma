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
		{{-- Miga de pan --}}
		<div class="full-width" id="banner-impact-page">
			<div class="xlage-8 medium-10 small-12 xlarge-offset-2 medium-offset-1 small-offset-0 columns container-breadcum"> 
				<h3 class="title-breadcum-impact-page">
					Impacto
				</h3>
				<small class="paragraph-breadcum-impact-page">
					Inicio / Impacto
				</small>
			</div>
		</div>
		<div class="row show-for-small-down" style="background:white;transform: translateY(-6px);">
			<div class="small-12 tablet-10 medium-6 small-offset-0 tablet-offset-1 medium-offset-0 columns no-padding">
				<img class="center-block" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/INNPULSA+DEC+2020/IMG1.png" alt="">
			</div>
			<div class="small-12 tablet-10 medium-6 small-offset-0 tablet-offset-1 medium-offset-0 columns no-padding">
				<img class="center-block" src="https://s3-us-west-2.amazonaws.com/static.tuproyecto.com/images/landing/innpulsa/INNPULSA+DEC+2020/IMG2.png" alt="">
			</div>
		</div>
		@include('public.landing.institutions.innpulsa.stats')
	</div>
	{{-- Footer --}}
	@include('public.landing.institutions.innpulsa.footer')
</div>
@stop