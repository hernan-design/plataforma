
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

	{{-- Google recaptcha --}}
	@if (Auth::guest())
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
	<!--[if lt IE 7]>
		<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve yourhttp://open.spotify.com/track/4sFbojhVXQv7dBC9PVCcRn experience.</p>
	<![endif]-->

	{{-- preloader full screen --}}
	@include('layout.preloader')
	<div id="wrapper-main-all" class="off-canvas-wrap" data-offcanvas style="transform: translateY(-4rem);">
		<div id="wrapper-inner-all" class="inner-wrap">
			{{-- Main Content Site --}}
			<section id="main-wrap" class="main-section login-alert-display" style="position:relative;">
				{{-- Alerts --}}
				<div data-alert class="alert-box-tp">
					<i class="icon-alert"></i>
					<span></span>
					<a href="#" class="close">&times;</a>
				</div>
				<section id="survey-wrapper">
                    <section id="survey-content" class="survey-content">
                    {{-- Render survey --}}
                </section>
		@include('public.surveytemplates')
	</section>

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

	{{-- js libraries --}}
	<script>window.document.url = "{{ URL::to('/') }}";</script>
	{{-- Libraries like: jQuery, foundation, underscore, backbone --}}
	<script src="{{ elixir('js/vendor/vendor.min.js') }}"></script>
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


