<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es"> <!--<![endif]-->
<head>
	@include('public.meta')

	<link rel="stylesheet" href="{{ elixir('css/vendor.min.css') }}">
	<link rel="stylesheet" href="{{ elixir('css/application.css') }}">
	{!! HTML::style('css/institution/'.App\RegistroSesion::getInstitutionSlug().'.css') !!}

	@if (Auth::check() && $app->environment('production'))
		{{-- Woopra --}}
		@include('public.woopra')
	@endif

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
</head>
<body>
	<!--[if lt IE 9]>
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

	<div id="wrapper-main-all" class="off-canvas-wrap" data-offcanvas>
		<div id="wrapper-inner-all" class="inner-wrap">
			{{-- Main Content Site --}}
			<section id="main-wrap" class="main-section login-alert-display">

				@if(isset($preloadedState))
					<script>window.__PRELOADED_STATE__ = JSON.parse(JSON.stringify({!! $preloadedState !!}));</script>
				@endif
				{{-- Render components pages --}}
				<div id="wrap-components">{!! $content ?? '' !!}</div>

				{{-- Templates Js --}}
				@include ('core.notification.templates')
			</section>

			<a class="exit-off-canvas"></a>
		</div>
	</div>

	{{-- Js libraries --}}
	<script>window.document.url = "{{ URL::to('/') }}";</script>
	{{-- Libraries like: jQuery, foundation --}}
	<script src="{{ elixir('js/vendor/third-party.js') }}"></script>
	<script src="{{ elixir('js/bundle.js') }}"></script>

	 @if (Auth::check() && $app->environment('production'))
		{{-- Realtime script --}}
		<script src="{{ elixir('js/realtime.app.js') }}"></script>
	 @endif

	@if ($app->environment('production'))
		{{-- Google Analytics API --}}
		@include('public.googleanalytics')

		@if( in_array(Request::segment(1), ['chat']) )
			{{-- Userguiding SDK --}}
			@include('public.userguiding')
		@endif
	@endif
</body>
</html>
