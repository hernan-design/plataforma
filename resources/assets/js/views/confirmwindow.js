/**
* Class ConfirmWindow extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ConfirmWindow = Backbone.View.extend({

		el: '#modal-base-confirm-tp',
		parameters: {
			template: _.template( ($('#project-confirm-remove-tpl').html() || '') ),
			titleConfirm: '',
			onConfirm: null,
			callBack: null,
			dataFilter: {}
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {
			// extends attributtes
			if( opts !== undefined && _.isObject(opts.parameters) )
				this.parameters = _.extend({}, this.parameters, opts.parameters);

			// Init attributes
			this.configAlert = {
				'wrapper': '#main-wrap',
				'closeTime': 10000,
				'speedOpen': 500,
				'speedClose': 500
			};
		},

		/*
		* Render View Element
		*/
		render: function() {
			this.setElement(this.el);

			var attributes = {};

			// extend attributes confirm window
			if( this.modal instanceof Backbone.Model ) _.extend(attributes, this.modal.toJSON(), this.parameters.dataFilter);

			// Change modal title and content
			this.$el.find('.content-modal').html( this.model instanceof Backbone.Model && typeof this.parameters.template == 'function' ?
                this.parameters.template(this.model.toJSON())
                : ( typeof this.parameters.template == 'function' ? this.parameters.template({}) : this.parameters.template) );
			this.$el.find('.inner-title-modal').html( this.parameters['titleConfirm'] );
			this.$el.foundation('reveal', 'open');

			// delegate events
			this.stopListening();
			this.undelegateEvents();
			this.$el.off('click');
			this.delegateEvents({
				'click .confirm-action': 'onConfirm'
			});

			return this;
		},

		/**
		* Project Close Confirm
		*/
		onConfirm: function (e) {
			e.preventDefault();

			var _this = this;

			this.$el.foundation('reveal', 'close');

			if( typeof this.parameters.onConfirm == 'function' ) {
				this.parameters.onConfirm.call(this, this.parameters.dataFilter );
			}else {
				this.model.destroy({
					processData: true,
					wait: true,
					data: _.extend({ '_token': $('meta[name="csrf-token"]').attr('content')}, this.parameters.dataFilter),
					success: function(model, resp) {

						// response success or error
						var type = resp.success ? 'success' : 'alert',
							text = resp.success ?
								(resp.message !== undefined ? resp.message : '')
								: resp.errors;

						if( _.isObject( resp.errors ) ) {

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
						_.extend( _this.configAlert, config );

						if( resp.success ){
							if( typeof _this.parameters.callBack == 'function' ) _this.parameters.callBack.call(_this, true, _this.parameters.dataFilter);

						}else{
							window.Misc.showAlertBox( _this.configAlert );
							if( typeof _this.parameters.callBack == 'function' ) _this.parameters.callBack.call(_this, false, _this.parameters.dataFilter);
						}
					}
				});
			}
		}
   });

})(jQuery, this, this.document);
