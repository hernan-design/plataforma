<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es"> <!--<![endif]-->
<head>
	@include('public.meta')

	<link rel="stylesheet" href="{{ asset('css/vendor.min.css') }}">
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
	<script src="{{ asset('js/vendor/vendor.min.js') }}"></script>
	<style>
		.top-bar-section li.has-dropdown,
		.tab-bar li.has-dropdown {
			position: relative !important;
		}
		.notification-layer-dropdown {
			display: none;
		}
		.notification-layer-dropdown.open {
			display: block !important;
			visibility: visible !important;
			opacity: 1 !important;
			position: absolute !important;
			top: 100% !important;
			right: 0 !important;
			left: auto !important;
			background: #ffffff !important;
			box-shadow: 0 4px 16px rgba(0, 0, 0, 0.18) !important;
			border: 1px solid #e0e0e0 !important;
			border-radius: 4px !important;
			z-index: 99999 !important;
		}
		#user-opt-menu.open {
			min-width: 200px !important;
			width: auto !important;
		}
		.content-notifications.open {
			width: 420px !important;
			max-width: 90vw !important;
		}
	</style>
	<script>
		$(document).ready(function() {
			if (window.jQuery && typeof window.jQuery.fn.foundation === 'function') {
				try { $(document).foundation(); } catch(e) {}
			}

			// Robust dropdown handler for header & notification dropdowns
			$(document).on('click', '[data-dropdown]', function(e) {
				var dropdownId = $(this).attr('data-dropdown');
				var $li = $(this).closest('li.has-dropdown');
				var $dropdown = $li.length ? $li.find('#' + dropdownId) : $('#' + dropdownId);
				if (!$dropdown.length) $dropdown = $('#' + dropdownId);
				if (!$dropdown.length) return;

				e.preventDefault();
				e.stopPropagation();

				var isOpen = $dropdown.hasClass('open') && $dropdown.is(':visible');
				$('.notification-layer-dropdown, [data-dropdown-content]').removeClass('open').hide();
				$('[data-dropdown]').removeClass('open');

				if (!isOpen) {
					$(this).addClass('open');
					$dropdown.addClass('open').show();
				}
			});

			// Close dropdowns on outside click
			$(document).on('click', function(e) {
				if (!$(e.target).closest('[data-dropdown], [data-dropdown-content], .notification-layer-dropdown').length) {
					$('.notification-layer-dropdown, [data-dropdown-content]').removeClass('open').hide();
					$('[data-dropdown]').removeClass('open');
				}
			});
		});
	</script>
	@vite(['resources/assets/js/components/main.js'])
	<script>
		var checkGlobalize = setInterval(function() {
			if (window.Globalize) {
				clearInterval(checkGlobalize);
				var script = document.createElement('script');
				script.src = "{{ asset('js/app.min.js') }}";
				document.body.appendChild(script);
			}
		}, 10);
	</script>
	@vite(['resources/assets/js/app-client.js'])

	 @if (Auth::check() && $app->environment('production'))
		{{-- Realtime script --}}
		<script src="{{ asset('js/realtime.app.js') }}"></script>
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
