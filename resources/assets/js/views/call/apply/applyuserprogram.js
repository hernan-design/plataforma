/**
* Class ApplyUserProgramView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ApplyUserProgramView = Backbone.View.extend({
		el: '#apply-entity-program',
		template: _.template( ($('#user-apply-program-tpl').html() || '') ),
		templateInvalid: _.template( ($('#invalid-message-apply-program-user-tpl').html() || '') ),
		events: {
			//
		},
		parameters: {
			url_convocatoria: '',
			step: '',
			programModel: null
		},

		/**
		* Constructor Method
		*/
		initialize: function (opts) {
			_.bindAll(this, 'responseValidateProgram');

			// extends parameters
            if( opts.parameters !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            //Init Attributes
            this.configAlert = {
				'wrapper': '#main-wrap',
				'closeTime': 8000,
				'speedOpen': 500,
				'speedClose': 500
			};

            // Events Listener
            this.listenToOnce(this.model, 'request', this.loadSpinner);
            this.listenToOnce(this.model, 'sync', this.successResquest);
		},

		/*
		* Render View Element
		*/
		render: function () {

			var attributes = this.parameters.programModel.toJSON();
			attributes['url_convocatoria'] = this.parameters.url_convocatoria;
			attributes['step'] = this.parameters.step;

			this.$el.html( this.template(attributes) );

			// Initialize attributes

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				$(document).foundation('tooltip', 'reflow');
			}

			// validate and consult the user
			this.validateUser();

			return this;
		},

		/**
		* validate application user
		*/
		validateUser: function () {

			var _this = this;

			this.model.url = function () {
				return window.Misc.urlFull( Route.route('usuario.auth') );
			}

			this.model.fetch();
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function ( model, resp, opts ) {
			window.Misc.setSpinner( this.$el );
		},

		successResquest: function ( model, resp, opts ) {
			// response success or error

			if( _.isObject(resp) ) {
				window.Misc.setSpinner( this.$('#content-data-entity-program') );
				$.get(window.Misc.urlFull( Route.route('convocatoria.aplicar.validacion', {codigo_convocatoria: this.parameters.programModel.get('codigo_convocatoria'), codigo_usuario: this.model.get('codigo_usuario')}) ), this.responseValidateProgram);
			}

			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': true
			});
		},

		/**
		* Handler responsive validate user
		* @param Object resp
		*/
		responseValidateProgram: function (resp) {

			if( resp.success !== undefined ) {

				var type = resp.success ? 'success' : 'alert',
					text = resp.success ?
						   (resp.message !== undefined ? resp.message : '')
						   : resp.errors;

				if( _.isObject(resp.errors) ){
					var listError = '<ul>';

					$.each(resp.errors, function(field, item) {
						 listError += '<li>'+ item[0] +'</li>';
					});
					listError += '</ul>';
					text = listError;
				}

				var conf = {
					'text': text,
					'type': type
				};

				_.extend(this.configAlert, conf);

				// validate responsive success
				if( resp.success ) {

					// if entity was applied
					if( resp.applied ) {
						this.$('#content-data-user-program').html( this.templateInvalid(_.extend({nombre_usuario: (this.model.get('nombre_usuario') || '')}, this.parameters.programModel.toJSON())) );

					}else {

						if( this.editUserProgram instanceof Backbone.View ) {
							this.editUserProgram.stopListening();
							this.editUserProgram.undelegateEvents();
						}

						// Render and fetch new entity
						this.editUserProgram = new app.ApplyEditUserProgramView({
							el: this.$('#content-data-user-program'),
							model: this.model,
							parameters: this.parameters
						});
						this.editUserProgram.render();
					}

				}else {
					window.Misc.showAlertBox(this.configAlert);
				}

				window.Misc.removeSpinner({
					'wrap': this.$('#content-data-entity-program'),
					'direct': true
				});
			}
		}
	});

})(jQuery, this, this.document);
