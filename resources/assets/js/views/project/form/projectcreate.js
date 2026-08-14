/**
* Class ProjectCreateView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function  ($, window, document, undefined) {

	app.ProjectCreateView = Backbone.View.extend({
		el: '#content-modal-create-entity',
		templateFormCompany: _.template( ($('#form-create-company-tpl').html() || '') ),
		templateFormEntrepreneurship: _.template( ($('#form-create-entrepreneurship-tpl').html() || '') ),
		templateFormGroup: _.template( ($('#form-create-group-tpl').html() || '') ),
        templateIdentifications: _.template( ($('#identification-type-tpl').html() || '') ),
		events: {
			'change #codigo_clase_empre_insti': 'onChangeClass',
			'submit #form-create-entity': 'onStore',
            'change #codigo_tipo_identificacion': 'onChangeTypeID'
		},
        parameters: {
            'redirect': null
        },

		/**
		* Constructor Method
		*/
		initialize: function (opts) {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender', 'openModalCreate');

            if(opts !== undefined && opts.template) {
                this.template = opts.template;
            }

            if ( opts !== undefined && _.isObject(opts.parameters) ) {
                this.parameters = $.extend({},this.parameters, opts.parameters);
            };

			//Init Attributes
			this.$modalLogin = $('#modal-login');
			this.$formCreate = this.$('#form-create-entity');
			this.$modalCreateProject = $('#modal-base-create-entity');

			this.configAlert = {
				'wrapper': this.$formCreate,
				'closeTime': 8000,
				'speedOpen': 500,
				'speedClose': 500
			};

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			//Events Listener
			this.listenTo( this.model, 'change', this.render );
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );

			// Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );

			// link to create entity
			$('.create-entity').off();
			$('.create-entity').on('click', this.openModalCreate);
		},

		/*
		* Render View Element
		*/
		render: function(){

            if(typeof this.template === 'function') {
                this.$el.html( this.template({}) );

                //Init Attributes
                this.$formCreate = this.$('#form-create-entity');
            }

			return this;
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function () {
			//
		},

		/**
		* Fires before of run render function
		*/
		afterRender: function () {
			this.ready();
		},

		/**
		* fires libraries js
		*/
		ready: function () {
			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				this.$formCreate.foundation('abide');
			}

			// reload plugins
			if( typeof window.initComponent.chosenTrigger == 'function' && _.has($.fn, 'chosen') )
				window.initComponent.chosenTrigger();

			if( typeof window.initComponent.select2Trigger == 'function' && _.has($.fn, 'select2') )
				window.initComponent.select2Trigger();

			if( typeof window.initComponent.configScrollbar == 'function' && _.has($.fn, 'perfectScrollbar') )
				window.initComponent.configScrollbar();

			if( typeof window.initComponent.configInputMask == 'function' && _.has($.fn, 'inputmask') )
				window.initComponent.configInputMask();

			if( typeof window.initComponent.datepickerTrigger == 'function' && _.has($.fn, 'datetimepicker') )
				window.initComponent.datepickerTrigger();

			if( typeof window.initComponent.initConfigForm == 'function' )
				window.initComponent.initConfigForm();
		},

		/**
		* Event for create project
		*/
		onStore: function (e) {
			e.preventDefault();

			var data = window.Misc.formToJson( e.target );
			this.model.resetAttrs({silent:true});

			this.model.save( data, {patch: true, wait:true} );
			// this.$formCreate.find(':submit').addClass('disabled');
		},

		onChangeClass: function (e) {
			e.preventDefault();
			var _this = this;
			var projectEmpty = new app.ProjectModel();

			this.validateClass($(e.currentTarget).val(), function (respState, respAlert, resp) {

				window.Misc.removeSpinner({
					'wrap': _this.$('#class-complementary-container'),
					'direct': true
				});
				if( respState ){
					switch( parseInt(resp.codigo_clase_emprendimiento) ) {
						case window._tp.getClassEntrepreneurship['company']:
								_this.$('#class-complementary-container').html( _this.templateFormCompany(projectEmpty.toJSON()) );
                                if( !_.isUndefined(_this.model.get('codigo_tipo_identificacion')) && !_.isNull(_this.model.get('codigo_tipo_identificacion')) && _this.model.get('codigo_tipo_identificacion') != 0 ){
                                    _this.validateInputIdentity( _this.model.get('codigo_tipo_identificacion') );
                                }else{
                                    _this.validateInputIdentity();
                                }
							break;
						case window._tp.getClassEntrepreneurship['entrepreneurship']:
								_this.$('#class-complementary-container').html( _this.templateFormEntrepreneurship(projectEmpty.toJSON()) );
							break;
						case window._tp.getClassEntrepreneurship['group']:
								_this.$('#class-complementary-container').html( _this.templateFormGroup(projectEmpty.toJSON()) );
							break;

						default:
							_this.$('#class-complementary-container').html('');
							$('#form-purchase-payment').find(':submit').removeClass('disabled');
						break;
					}

					_this.ready();
				}
			});
		},

		/**
		* validate classInstitution of the team entity
		* @param String classInstitution
		* @return Array | [Boolean, Object]
		*/
		validateClass: function (classEntity, callback) {

			var _this = this,
				respReturn = true,
				configAlert = this.configAlert;
			window.Misc.setSpinner( _this.$('#class-complementary-container') );

			$.get( window.Misc.urlFull(Route.route('proyecto.categoriaclase.show', {categoriaclase: classEntity})), function (resp) {

				if( resp.success !== undefined ){

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

					_.extend(configAlert, conf);

					if (!resp.success) {
						respReturn = false;
					}
				}

				if( typeof callback == 'function' ){
					callback.call(null, respReturn, configAlert, resp);
				}
			});
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function (model, xhr, opts) {

			window.Misc.setSpinner( '#main-wrap' );
		},

		/**
		* response of the server
		*/
		responseServer: function ( model, resp, opts ) {

			// response success or error
			var type = resp.success ? 'success' : 'alert',
				text = resp.success ?
					(resp.message !== undefined ? resp.message : 'El proyecto se creo.')
					: resp.errors;


			if( _.isObject( resp.errors ) ){

				var listError = '<ul>';

				$.each(resp.errors, function(field, item) {
					 listError += '<li>'+ item[0] +'</li>';
				});
				listError += '</ul>';

				text = listError;
			}

			var config = {
				'text': text,
				'type': type
			};
			_.extend( this.configAlert, config );

			//complete proccess
			window.Misc.removeSpinner({
				'wrap': '#main-wrap',
				'direct': false,
				'callback': (function (conf, re, _this, $formReset) {
					return function () {
						$formReset.find(':submit').removeClass('disabled');

						if( re.success !== undefined ){
							if( re.success ){
								$formReset[0].reset();
								$formReset.find('.chosen-select')
										  .trigger("chosen:updated");
								if( $formReset.data('type') == 'program'){
									// Trigger saved event
									$formReset.trigger('saved', _this.model);
								}else{
                                    // Redirect
                                    if( !_.isUndefined(_this.parameters.redirect) && !_.isNull(_this.parameters.redirect) ) {
                                        window.location = _this.parameters.redirect;
                                    }else{
                                        window.location = window.Misc.urlFull( Route.route('proyecto.proyecto.tab', {proyecto: _this.model.get('url_nickname'), tab: 'basico'}) );
                                    }
                                }

							}else{
								var configShowAlertBox = {
									'closeTime': 7000,
									'speedOpen': 500,
									'speedClose': 500
								};
								_.extend( configShowAlertBox, config );

								window.Misc.showAlertBox( configShowAlertBox );
							}
						}
					};
				})(this.configAlert, resp, this, this.$formCreate)
			});
		},

		/**
		* on open modal create
		*/
		openModalCreate: function (e) {
			//e.preventDefault();

			if( window.Misc.checkSession(false) ) {
				this.$modalCreateProject.foundation('reveal', 'open');

			}else{
				this.$modalLogin.foundation('reveal','open');
			}
		},

        /**
        * Change type ID
        */
        onChangeTypeID: function (e) {
           // e.preventDefault();
            var typeIdentity = $(e.currentTarget).val();
            this.validateInputIdentity( typeIdentity );
        },

        validateInputIdentity: function (data) {
            var attributes = this.model.toJSON(),
                classInput = '',
                limit = '';

            if( data == window._tp.getTypeID['cc'] || data == window._tp.getTypeID['nit'] || data == window._tp.getTypeID['ti'] ){
                attributes.classInput = 'indetification-mask';
                if( data == window._tp.getTypeID['nit'] ){
                    attributes.limit = '9';
                }else{
                    attributes.limit = '10';
                }
            }

            this.$('#identification-type').html( this.templateIdentifications( attributes ) );
            this.ready();
        }
	});

})(jQuery, this, this.document);
