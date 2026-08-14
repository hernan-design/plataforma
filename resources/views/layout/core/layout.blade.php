<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="es"> <!--<![endif]-->
<head>

	@include('public.meta')

	@if($app->environment('production'))
		@if (App\RegistroSesion::getIdTagManager() !== null)
			{{-- Google tag manager --}}
			@include('public.tagmanager_head', ['id_tag_manager' => App\RegistroSesion::getIdTagManager()])
		@endif
	@endif

	<link rel="stylesheet" href="{{ elixir('css/vendor.min.css') }}">
	<link rel="stylesheet" href="{{ elixir('css/application.css') }}">
	{!! HTML::style('css/institution/'.App\RegistroSesion::getInstitutionSlug().'.css') !!}

	@if (Auth::check() && $app->environment('production'))
		{{-- Woopra --}}
		@include('public.woopra')
	@endif

	{{-- Google recaptcha --}}
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	{{-- @if (Auth::guest())
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	@endif --}}

	{{-- Modernizr --}}
	{!! HTML::script('js/vendor/modernizr.min.js') !!}

	<script>
		/**
		* default image
		* @param imgEl Element
		* @param imgDefault String default image url
		*/
		function imageDefault (imgEl, imgDefault) { imgDefault || (imgDefault = ''); if (imgEl.getAttribute('src') != imgDefault) imgEl.setAttribute('src', imgDefault); }
	</script>


	@if ($app->environment('production'))
		@if (App\RegistroSesion::getIdFacebookPixel() !== null)
			{{-- Pixel Facebook --}}
			@include('public.facebookpixel', ['id_facebook_pixel' => App\RegistroSesion::getIdFacebookPixel()])
		@endif
	@endif

</head>
<body>
	@if($app->environment('production'))
		@if (App\RegistroSesion::getIdTagManager() !== null)
			{{-- Google tag manager --}}
			@include('public.tagmanager_body', ['id_tag_manager' => App\RegistroSesion::getIdTagManager()])
		@endif
	@endif
	<!--[if lt IE 7]>
		<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve yourhttp://open.spotify.com/track/4sFbojhVXQv7dBC9PVCcRn experience.</p>
	<![endif]-->

	{{-- preloader full screen --}}
	@include('layout.preloader')

	{{-- Header Site --}}
	<header id="header-wrap" class="fixed">
		@include('layout.core.header')
	</header>
	{{-- Main menu options --}}
	@include('layout.mainmenu')

	<div id="wrapper-main-all" class="off-canvas-wrap" data-offcanvas data-pepe>
		<div id="wrapper-inner-all" class="inner-wrap">

			{{-- Strip for login and register buttons --}}
			@if( !in_array(Request::segment(1), ['login', 'register']) && Auth::guest() )
				@include('auth.stripsignup')
			@endif

			{{-- Main Content Site --}}
			<section id="main-wrap" class="main-section login-alert-display" style="position:relative;">
				{{-- Alerts --}}
				<div data-alert class="alert-box-tp">
					<i class="icon-alert"></i>
					<span></span>
					<a href="#" class="close">&times;</a>
				</div>
				@yield('content')

				{{-- Templates Js --}}
				@include('layout.core.templates')
				@include ('core.notification.templates')
				{{-- Modal base --}}
				@include('public.modalbase')
			</section>

			<a class="exit-off-canvas"></a>
		</div>

		@if (Auth::check())
			{{-- Modal create project --}}
			{{-- Templates Js --}}
			@include('core.project.form.templates')
		@endif

	</div>

	@if (Auth::check() && App\RegistroSesion::getMessageInstitution() !== null)
		<footer>
			@include('layout.core.footer', ['mensaje' => App\RegistroSesion::getMessageInstitution()])
		</footer>
	@endif

	{{-- js libraries --}}
	<script>window.document.url = "{{ URL::to('/') }}";</script>
	{{-- Libraries like: jQuery, foundation, underscore, backbone --}}
	<script src="{{ elixir('js/vendor/vendor.min.js') }}"></script>
	<script src="https://f.vimeocdn.com/js/froogaloop2.min.js"></script>
	{{-- Components --}}
	<script src="{{ elixir('js/component.js') }}"></script>
	<script src="{{ elixir('js/app.min.js') }}"></script>

	@if (Auth::check() && $app->environment('production'))
		{{-- Realtime script --}}
		<script src="{{ elixir('js/realtime.app.js') }}"></script>
	@endif

	@if ($app->environment('production'))
		{{-- Google Analytics API --}}
		@include('public.googleanalytics')
	@endif
</body>
</html>
