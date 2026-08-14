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
		@include('public.landing.institutions.dinamiza.header')
        

        {{-- banner video section --}}
        @include('public.landing.institutions.dinamiza.banner')

		
        {{-- main land  --}}
		<div id="main-land" class="main-section">

            {{-- testimonial section --}}
            @include('public.landing.institutions.dinamiza.testimonial')

            {{-- video section --}}
            @include('public.landing.institutions.dinamiza.video')

            {{-- ecosistema section --}}
            @include('public.landing.institutions.dinamiza.ecosistema')
            
            {{-- register section --}}
            @include('public.landing.institutions.dinamiza.register')
            
            {{-- partners section --}}
            @include('public.landing.institutions.dinamiza.partners')

            {{-- contact section --}}
            @include('public.landing.institutions.dinamiza.contact')
        </div>

        {{-- footer section --}}
        @include('public.landing.institutions.dinamiza.footer')
    </div>
@stop
