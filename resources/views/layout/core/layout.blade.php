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

	<link rel="stylesheet" href="{{ asset('css/vendor.min.css') }}">
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
		document.url = window.location.origin;
		window.document.url = window.location.origin;
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
	<script>
		window.document.url = "{{ URL::to('/') }}";
		window.global = window;
		window.process = { env: { NODE_ENV: 'production' } };
		if (window.console && console.warn) {
			var _origWarn = console.warn;
			console.warn = function() {
				var msg = Array.prototype.join.call(arguments, ' ');
				if (
					msg.indexOf('moment.updateLocale') !== -1 ||
					msg.indexOf('defineLocale') !== -1 ||
					msg.indexOf('momentjs.com') !== -1 ||
					msg.indexOf('componentWillReceiveProps') !== -1 ||
					msg.indexOf('componentWillUpdate') !== -1 ||
					msg.indexOf('rename-unsafe-lifecycles') !== -1 ||
					msg.indexOf('childContextTypes') !== -1 ||
					msg.indexOf('legacy-context') !== -1 ||
					msg.indexOf('defaultProps') !== -1
				) {
					return;
				}
				_origWarn.apply(console, arguments);
			};
		}
		if (window.console && console.error) {
			var _origErr = console.error;
			console.error = function() {
				var msg = Array.prototype.join.call(arguments, ' ');
				if (
					msg.indexOf('ReactDOM.render') !== -1 ||
					msg.indexOf('switch-to-createroot') !== -1 ||
					msg.indexOf('is no longer supported in React 18') !== -1 ||
					msg.indexOf('childContextTypes') !== -1 ||
					msg.indexOf('legacy-context') !== -1 ||
					msg.indexOf('Unexpected key') !== -1 ||
					msg.indexOf('defaultProps') !== -1
				) {
					return;
				}
				_origErr.apply(console, arguments);
			};
		}
	</script>
	{{-- Libraries like: jQuery, foundation, underscore, backbone --}}
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

			// Safe jQuery UI / Bootstrap tooltip bridge to prevent "no such method 'hide' for tooltip widget instance"
			if (window.jQuery && window.jQuery.ui && window.jQuery.ui.tooltip && window.jQuery.ui.tooltip.prototype) {
				if (!window.jQuery.ui.tooltip.prototype.hide) {
					window.jQuery.ui.tooltip.prototype.hide = function() {
						try { return this.close ? this.close.apply(this, arguments) : undefined; } catch(e) {}
					};
				}
				if (!window.jQuery.ui.tooltip.prototype.show) {
					window.jQuery.ui.tooltip.prototype.show = function() {
						try { return this.open ? this.open.apply(this, arguments) : undefined; } catch(e) {}
					};
				}
			}
			if (window.jQuery && window.jQuery.fn && window.jQuery.fn.tooltip) {
				var _origTooltip = window.jQuery.fn.tooltip;
				window.jQuery.fn.tooltip = function(option) {
					if (typeof option === 'string' && (option === 'hide' || option === 'show' || option === 'toggle')) {
						if (this.data('bs.tooltip') && window.jQuery.fn.bsTooltip) {
							try { return window.jQuery.fn.bsTooltip.apply(this, arguments); } catch(e) {}
						}
						if (option === 'hide') {
							if (this.data('ui-tooltip') || this.data('uiTooltip')) {
								try { return _origTooltip.call(this, 'close'); } catch(e) {}
							}
							return this;
						}
						if (option === 'show') {
							if (this.data('ui-tooltip') || this.data('uiTooltip')) {
								try { return _origTooltip.call(this, 'open'); } catch(e) {}
							}
							return this;
						}
					}
					try {
						return _origTooltip.apply(this, arguments);
					} catch(err) {
						return this;
					}
				};
			}

			// Robust dropdown handler for header & notification dropdowns
			$(document).on('click', '[data-dropdown]', function(e) {
				var dropdownId = $(this).attr('data-dropdown');
				console.log('DROPDOWN_CLICKED:', dropdownId, $(this));
				var $li = $(this).closest('li.has-dropdown');
				var $dropdown = $li.length ? $li.find('#' + dropdownId) : $('#' + dropdownId);
				if (!$dropdown.length) $dropdown = $('#' + dropdownId);
				console.log('FOUND_DROPDOWN:', $dropdown.length, $dropdown);
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

			// Robust modal close handler for Foundation Reveal modals (.close-reveal-modal and backdrop)
			$(document).on('click', '.close-reveal-modal', function(e) {
				e.preventDefault();
				e.stopPropagation();
				var $modal = $(this).closest('[data-reveal], .reveal-modal, .reveal-modal-main, .reveal-modal-form');
				if (!$modal.length) {
					$modal = $('[data-reveal]:visible, .reveal-modal:visible, .reveal-modal-main:visible, .reveal-modal-form:visible');
				}
				if (window.Foundation && window.Foundation.libs && window.Foundation.libs.reveal) {
					window.Foundation.libs.reveal.locked = false;
				}
				if ($modal.length && typeof $modal.foundation === 'function') {
					try {
						$modal.foundation('reveal', 'close');
					} catch(err) {
						console.warn('Foundation reveal close error:', err);
					}
				}
				setTimeout(function() {
					if ($modal.is(':visible') || $('.reveal-modal-bg').is(':visible')) {
						$modal.removeClass('open').css({ display: 'none', visibility: 'hidden', opacity: 0 });
						$('.reveal-modal-bg').remove();
						$('body').removeClass('modal-open').css('overflow', '');
						$modal.trigger('closed.fndtn.reveal');
					}
				}, 150);
			});

			$(document).on('click', '.reveal-modal-bg', function(e) {
				var $modal = $('[data-reveal]:visible, .reveal-modal:visible, .reveal-modal-main:visible, .reveal-modal-form:visible');
				if ($modal.attr('data-noclose') !== undefined) {
					return;
				}
				e.preventDefault();
				if (window.Foundation && window.Foundation.libs && window.Foundation.libs.reveal) {
					window.Foundation.libs.reveal.locked = false;
				}
				if ($modal.length && typeof $modal.foundation === 'function') {
					try {
						$modal.foundation('reveal', 'close');
					} catch(err) {}
				}
				setTimeout(function() {
					if ($modal.is(':visible') || $('.reveal-modal-bg').is(':visible')) {
						$modal.removeClass('open').css({ display: 'none', visibility: 'hidden', opacity: 0 });
						$('.reveal-modal-bg').remove();
						$('body').removeClass('modal-open').css('overflow', '');
						$modal.trigger('closed.fndtn.reveal');
					}
				}, 150);
			});

			// Robust Foundation tab handler for dynamic and cross-container tabs
			$(document).on('click', '[data-tab] > li > a, [data-tab] > dd > a, [data-tab] a[href^="#"], [data-tab] a[aria-controls]', function(e) {
				var $link = $(this);
				var href = $link.attr('href');
				var controls = $link.attr('aria-controls');
				var targetId = '';

				if (href && href.charAt(0) === '#' && href.length > 1) {
					targetId = href;
				} else if (controls) {
					targetId = '#' + controls;
				}

				if (!targetId || targetId === '#') return;

				var $target = $(targetId);
				if ($target.length) {
					var $ul = $link.closest('[data-tab]');
					$ul.find('> li, > dd, .tab-title').removeClass('active');
					$link.closest('li, dd, .tab-title').addClass('active');

					var $tabsContent = $target.closest('.tabs-content');
					if ($tabsContent.length) {
						$tabsContent.children('.content').removeClass('active');
					} else {
						$target.siblings('.content').removeClass('active');
					}
					$target.addClass('active');
				}
			});
		});
	</script>
	<script src="{{ asset('js/views/login/googlerecaptcha.js') }}?v={{ time() }}"></script>
	<script src="{{ asset('js/views/login/usersignup.js') }}?v={{ time() }}"></script>
	{{-- Components --}}
	@vite(['resources/assets/js/components/main.js'])
	<script>
		var checkGlobalize = setInterval(function() {
			if (window.Globalize) {
				clearInterval(checkGlobalize);
				var script = document.createElement('script');
				script.src = "{{ asset('js/app.min.js') }}?v={{ time() }}";
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
	@endif
</body>
</html>
