/**
* Class UserSingUpView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.UserSingUpView = Backbone.View.extend({

		el: 'body',
		events:{
			'submit #form-new-account': 'onValidateRegister',
			// 'blur #fld-email-register': 'onValidateEmailRegister',
			// 'blur #correo_electronico': 'onValidateEmailLogin'
		},
		templateTermsLogin: _.template( ($('#terms-policy-login-tpl').html() || '') ),
		templateTermsCheck: _.template( ($('#terms-policy-login-check-tpl').html() || '') ),

		/**
		* Constructor Method
		*/
		initialize : function() {

			_.bindAll(this, 'onValidateEmailLogin');

			var _this = this;

			//Init Attributes
			this.$modalLogin = $('#modal-login');
			this.$loginForm = $('#form-login-email');
			this.$registerForm = $('#form-new-account');
			this.$termsPolicy = this.$('#terms-policy-login');
			this.$fldEmailLogin = this.$('#correo_electronico:not([data-reveal] input)');
			this.configAlert = {
				'wrapper': this.$el,
				'closeTime': 8000,
				'speedOpen': 500,
				'speedClose': 500
			};

			if( this.$termsPolicy.length )
				this.$termsPolicy.html( this.templateTermsLogin({}) );

			// events handlers
			// $(this.$modalLogin).on('opened.fndtn.reveal', this.onValidateEmailLogin );
			// $(window).one('load', function () {
			// 	_this.onValidateEmailLogin();

   //              if( _.has($.fn, 'foundation') ) {
   //                  $(document).foundation('abide', 'reflow');
   //              }
			// })
		},

		/*
		* Render View Element
		*/
		render: function(){
			//
		},

		/**
		* validate Register
		*/
		onValidateRegister: function (event) {
			event.preventDefault();
			event.target.submit();

			// var _this = this,
			// 	validations = [],
			// 	sendData = {
			// 		'correo_electronico': ''
			// 	},
			// 	data = window.Misc.formToJson(event.target);

			// if( _.isObject(data) )
			// 	_.extend(sendData, data);

			// this.validateEmail(sendData, function (respState, respMessage, resp) {

			// 	_this.$loginForm.find(':submit').val(resp.labelbtn);

			// 	if( !respState ){
			// 		_this.$modalLogin.find('input#correo_electronico').val( data['correo_electronico'] );
			// 		_this.$modalLogin.foundation('reveal', 'open');

			// 		window.Misc.showAlertBox( respMessage );

			// 	}else {
			// 		_this.$el.find('input#fecha_nacimiento_usuario').val([data.year, data.month, data.day].join('-'));
			// 		event.target.submit();
			// 	}
			// });
		},

		/**
		* validate email register
		*/
		onValidateEmailRegister: function (e) {

			var _this = this,
				email = $(e.currentTarget).val(),
				sendData = {
					'correo_electronico': email
				};

			this.validateEmail(sendData, function (respState, respAlert, resp) {

				_this.$loginForm.find(':submit').val(resp.labelbtn);
				_this.$termsPolicy.html( _this.templateTermsLogin({}) );

				// if email exists on another institution
				if( !respState ){

					_this.$termsPolicy.html( _this.templateTermsCheck({}) );
					if(_.has($.fn, 'foundation') ) _this.$loginForm.foundation('abide');

					_this.$modalLogin.find('input#correo_electronico').val( email );
					_this.$modalLogin.foundation('reveal', 'open');


					_.extend(respAlert, {
						'closeTime': 15000
					});
					window.Misc.showAlertBox( respAlert );
				}

			});
		},

		/**
		* validate email login
		*/
		onValidateEmailLogin: function (e) {

			// if it's a opened event of foundation modal, validate to make once
			if (e !== undefined && e.type == 'opened' && e.namespace !== 'fndtn.reveal') return;

			var _this = this,
				email = (e !== undefined && e.type != 'opened' && $(e.currentTarget).length) ?
							$(e.currentTarget).val() :
								(!this.$fldEmailLogin.length && e !== undefined) ?
										this.$('#correo_electronico').val() : this.$fldEmailLogin.val(),
				sendData = {
					'correo_electronico': email
				};

			this.validateEmail(sendData, function (respState, respAlert, resp) {

				_this.$loginForm.find(':submit').val(resp.labelbtn);
				_this.$termsPolicy.html( _this.templateTermsLogin({}) );

				// if email exists on another institution
				if( !respState ){
					_this.$termsPolicy.html( _this.templateTermsCheck({}) );
					if(_.has($.fn, 'foundation') ) _this.$loginForm.foundation('abide');

					_.extend(respAlert, {
						'closeTime': 15000
					});
					window.Misc.showAlertBox( respAlert );
				}

			});

		},

		/**
		* validate E-mail of the register
		* @param String email
		* @return Array | [Boolean, Object]
		*/
		validateEmail: function (sendData, callback) {

			var _this = this,
				respReturn = true,
				configAlert = this.configAlert,
				_data = {
					'correo_electronico': ''
				};

			if( _.isObject(sendData) )
				_.extend(_data, sendData);

			if( window.Misc.isEmail(_data['correo_electronico']) ) {

				$.get(document.url + Route.route('auth.valid.exist'), _data, function (resp) {

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

						if (resp.success) {
							if(resp.isvalid && !resp.isjoin){

								respReturn = false;
							}

						}else {
							respReturn = false;
						}
					}

					if( typeof callback == 'function' ){
						callback.call(null, respReturn, configAlert, resp);
					}
				});
			}
		}
	});


})(jQuery, this, this.document);
