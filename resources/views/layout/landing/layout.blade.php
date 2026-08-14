<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es"> <!--<![endif]-->
	<head>

		@include('public.meta')

		@if($app->environment('production'))
				@if (App\RegistroSesion::getIdTagManager() !== null)
				{{-- Google tag manager --}}
				@include('public.tagmanager_head', ['id_tag_manager' => App\RegistroSesion::getIdTagManager()])
			@endif
		@endif

		@hasSection('excludestyles')
		@else
		<link rel="stylesheet " href="{{ elixir('css/vendor-landing.min.css') }}">
		<link rel="stylesheet" href="{{ elixir('css/landing.css') }}">

		{!! HTML::style('css/institution/'.$institution->slug_institucion.'_landing.css') !!}
		@if( $institution->fuentes_personalizadas )
			{!! HTML::style('css/institution/fonts/'.$institution->slug_institucion.'.css') !!}
		@endif
		@endif

		{{-- Modernizr --}}
		{!! HTML::script('js/vendor/modernizr.min.js') !!}

		<script>
			/**
			* default image
			* @parem imgEl Element
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

		@yield('head')
 	</head>
	<body id="body" data-spy="scroll" data-target=".navbar" data-offset="100">
		@if($app->environment('production'))
			@if (App\RegistroSesion::getIdTagManager() !== null)
				{{-- Google tag manager --}}
				@include('public.tagmanager_body', ['id_tag_manager' => App\RegistroSesion::getIdTagManager()])
			@endif
		@endif
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve yourhttp://open.spotify.com/track/4sFbojhVXQv7dBC9PVCcRn experience.</p>
		<![endif]-->

		@yield('content')

		{{-- Templates Js --}}
		@include('layout.core.templates')
		@include ('core.notification.templates')
		{{-- Modal base --}}
		@include('public.modalbase')

		{{-- js libraries --}}
	    <script>window.document.url = "{{ URL::to('/') }}";</script>
		{{-- Libraries so: jQuery, underscore, backbone --}}
		<script src="{{ elixir('js/vendor/vendor-landing.min.js') }}"></script>
		<script src="{{ elixir('js/landing.min.js') }}"></script>

		@if (Auth::check() && $app->environment('production'))
			{{-- Realtime script --}}
			<script src="{{ elixir('js/realtime.app.js') }}"></script>
		@endif

		@if ($app->environment('production'))
			{{-- Google Analytics API --}}
			@include('public.googleanalytics')
		@endif
	</body>
	@yield('scripts')
</html>
