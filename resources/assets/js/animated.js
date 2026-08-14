/**
* Animation for application elements
* @author TuPoryecto
* @frontend Desarrollador: @krobing
* @link tuproyecto.com
*/

(function ($, window, document, undefined) {

	var InitAnimated = function () {
		//
	};

	InitAnimated.prototype = {

		defaults: {

		},

		/**
		* Constructor or Initialize Method
		*/
		initialize: function (opts) {

			// Extends default config
			this.settings = $.extend({}, this.defaults, opts);

			// Initialize Methods
			this.slidingMenuSide();
			// this.dropdownsMotion();
			this.configOffCanvas();
			this.focusTo();
			this.toggleMainMenu();
			this.slidingDropdown();
			this.toggleSignUp();
            this.preloadTolink();
		},

		/**
		* slide of side menu
		*/
		slidingMenuSide: function () {

			$(document).on('click', '.hide-fx-left-btn, .hide-fx-right-btn', function (event) {
				event.preventDefault();

				var $btnShow = $(event.currentTarget),
					$colLeft = $('.fx-main-content .fx-col-left'),
					$colRight = $('.fx-main-content .fx-col-right');

				if( $btnShow.hasClass('hide-fx-left-btn') ){

					if( $colLeft.hasClass('is-hide') ){
						$colLeft.css({
							'margin-left': '0px'
						}).removeClass('is-hide');

						$('.hide-fx-left-btn').removeClass('on');

					}else {
						$colLeft.css({
							'margin-left': function (dim) {
								return '-'+ ( $(this).outerWidth(true) + 5 ) +'px';
							}
						}).addClass('is-hide');

						$('.hide-fx-left-btn').addClass('on');
					}

					$('.is-sticky > [class*="sticky-"]').sticky('update');
					// $('.is-sticky > [class*="sticky-"]').each(function(index, el) {
					//     $(el).sticky('update');
					// });

				}else if( $btnShow.hasClass('hide-fx-right-btn')){

					if( $colRight.hasClass('is-hide') ){
						$colRight.css({
							'margin-right': '0px'
						}).removeClass('is-hide');

						$('.hide-fx-right-btn').removeClass('on');

					}else {
						$colRight.css({
							'margin-right': function (dim) {
								return '-'+ ( $(this).outerWidth(true) + 5 ) +'px';
							}
						}).addClass('is-hide');

						$('.hide-fx-right-btn').addClass('on');
					}

					$('.is-sticky > [class*="sticky-"]').sticky('update');
				}
			});
		},

		/**
		* sliding aside dropdown
		*/
		slidingDropdown: function () {

			var _this = this;

			// handler with click event
			$(document).on('click', '.toggle-slide-drop', function(event) {
				event.preventDefault();

				// if browser window is least 1024px
				if( $(window).width() <= 1024 ) {

					if(!$('.content-filters-sidemenu').hasClass('dd')){

						$('.content-filters-sidemenu').removeClass('dropdown-transition-md').addClass('dd');
						$(event.currentTarget).removeClass('on');

					}else{
						$('.content-filters-sidemenu').removeClass('dd').addClass('dropdown-transition-md');
						$(event.currentTarget).addClass('on');
					}
				}
			});

			// handler with resize window event
			this.breakpointsDropdown();
			$(window).on('resize load', function (event) {
				_this.breakpointsDropdown();
			});
		},

		/**
		* breakpoints dropdown
		*/
		breakpointsDropdown: function () {
			// if browser window is least 1024px
			if( $(window).width() <= 1024 ) {

				$('.content-filters-sidemenu').removeClass('dropdown-transition-md').addClass('dd');
				$('.toggle-slide-drop').removeClass('on');

			}else {
				$('.content-filters-sidemenu').addClass('dropdown-transition-md').removeClass('dd');
				// $('.toggle-slide-drop').addClass('on');
			}
		},

		/**
		*
		*/
		dropdownsMotion: function () {
			$(document).on('click.fndtn.dropdown', '.btn-plus-create', function (event) {
				event.preventDefault();
				event.stopPropagation();

				var $linkDrop = $(event.currentTarget);

				if( $linkDrop.data('dropdown') ){
					var $dropdown = $( '#'+ $linkDrop.data('dropdown') );
					$dropdown.foundation('dropdown', 'toggle', $linkDrop);
				}
			});
		},
		/**
		* configuring show and hide of offCanvas menu
		*/
		configOffCanvas: function  () {
		    $('#boton-buttom-menu').click(function(){
		        $('.bottom-off-canvas-menu').addClass('show-top-off-canvas');
            });
			$(document).on('open.fndtn.offcanvas', '[data-offcanvas]', '[data-pepe]', function (event) {
				var $btnToggle = $('.left-off-canvas-toggle.md-animated-icon.md-hamburger__icon');
				if( $(event.target).data('offcanvas') !== undefined ){
					$('.left-off-canvas-menu').addClass('show-right-off-canvas');
					$btnToggle.addClass('active');
					$btnToggle.removeClass('no-active');
                    document.body.style.overflow = 'hidden';
				}
			});
			$(document).on('close.fndtn.offcanvas', '[data-offcanvas]', function (event) {
				var $btnToggle = $('.left-off-canvas-toggle.md-animated-icon.md-hamburger__icon');
				$('.left-off-canvas-menu').removeClass('show-right-off-canvas');
				$('.bottom-off-canvas-menu').removeClass('show-top-off-canvas');
				$btnToggle.removeClass('active');
				$btnToggle.addClass('no-active');
                document.body.style.overflow = 'auto';
			});
		},
		/**
		* focus to
		*/
		focusTo: function () {
			$(document).on('click', '[data-focuses]', function (event) {
				event.preventDefault();

				var $el = $(this);

				if( $el.data('focuses') ) {
					$('#'+$el.data('focuses')).focus();
				}
			})
		},

		/**
		* toggle main menu
		*/
		toggleMainMenu: function () {
			$(document).off('click', '.md-hamburger-close__icon');
			$(document).on('click', '.md-hamburger-close__icon', function (event) {
				event.preventDefault();

				var $toggleMenu = $(this),
					$topMenuOpts = $('#topmenu-main-options'),
					isActive = $toggleMenu.hasClass('active');

				$toggleMenu.toggleClass('active', !isActive);
				$toggleMenu.toggleClass('no-active', isActive);

				if( $toggleMenu.hasClass('main-menu-toggle') ) {
					$topMenuOpts.toggleClass('show-topmenu-options', !isActive);
					$('body').css('overflow', isActive ? 'auto' : 'hidden');
				}
			});
		},

		/**
		*
		*/
		toggleSignUp: function () {

			$(document).on('click', '.show-strip-signup', function (event) {
				event.preventDefault();

				$('.strip-sign-up-mobile').slideToggle('fast');
			});
		},

        /**
         * when the link was clicked in the main menu options, start preload
         */
        preloadTolink: function () {
            $(document).on('click', '.load-when-linking', function (event) {
                $('body').removeClass('loaded');
            });
        }
	};

	/**
	* Expose the class either via AMD, CommonJS or the global object
	*/
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return InitAnimated;
        });
    }
    else if (typeof module === 'object' && module.exports) {
        module.exports = InitAnimated;
    }
    else {
    	//Initialize animated components
		//------------------------------
		$(function() {
	    	window.initAnimated = new InitAnimated();
			window.initAnimated.initialize();
		});
    }

})(
	(this && this.jQuery) || require('jquery'),
	this || global,
	(this && this.document) || global.document
);
