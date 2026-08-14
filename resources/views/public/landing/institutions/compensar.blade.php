@extends('layout.landing.layout')
@section('content')
    <div id="wrapper-land" class="login-alert-display wrapper-{{ $institution->slug_institucion }}">
        <div data-alert class="alert-box-tp">
			<i class="icon-alert"></i>
			<span></span>
			<a href="#" class="close">&times;</a>
		</div>

        {{-- Main menu options --}}
        @include('layout.mainmenu')


        {{-- Header --}}
		@include('public.landing.institutions.compensar.header')

        {{-- testimonial section --}}
        @include('public.landing.institutions.compensar.slider')

        {{-- main land  --}}
		<div id="main-land" class="main-section">

            {{-- testimonial section --}}
            @include('public.landing.institutions.compensar.about')

            {{-- route --}}
            @include('public.landing.institutions.compensar.target-route')

            {{-- projects --}}
            @include('public.landing.institutions.compensar.projects')

            {{-- info talk --}}
            @include('public.landing.institutions.compensar.info-talk')

            {{-- tips --}}
            @include('public.landing.institutions.compensar.tips')

            {{-- faq --}}
            @include('public.landing.institutions.compensar.faq')

            {{-- contact --}}
            @include('public.landing.institutions.compensar.contact')
        </div>

        {{-- testimonial section --}}
        @include('public.landing.institutions.compensar.footer')

    </div>
@stop