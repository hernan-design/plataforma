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
		@include('public.landing.institutions.redcoo.header')
        
        {{-- testimonial section --}}
        @include('public.landing.institutions.redcoo.banner')
		
        {{-- main land  --}}
		<div id="main-land" class="main-section">

            {{-- about --}}
            @include('public.landing.institutions.redcoo.about')

            {{-- modules --}}
            @include('public.landing.institutions.redcoo.modules')

            {{-- news --}}
            @include('public.landing.institutions.redcoo.news')

            {{-- partners --}}
            @include('public.landing.institutions.redcoo.partners')
        </div>

        {{-- Footer --}}
		<footer class="footer" id="footer-land">
			{{-- Sitemap footer --}}
			@include('public.landing.sitemap')

			{{-- Social and copyright footer --}}
			@include('public.landing.footer')
		</footer>

    </div>
@stop
