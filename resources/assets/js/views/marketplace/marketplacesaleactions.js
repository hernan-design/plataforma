/**
* Class MarketPlaceSaleActionsView extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MarketPlaceSaleActionsView = Backbone.View.extend({
		className: 'icons-connect',
		template: _.template( ($('#buttons-sales-tpl').html() || '') ),
		events: {
			'click .cancel-sale': 'onCancel',
			'click .confirm-sale': 'onConfirmed',
			'click .evaluation-sales': 'onEvaluation',
			'click .cancellation-reason': 'onEvaluation',
			'click .deriverables-sale': 'onDeliverables',
			'click .confirm-offer': 'onConfirmOffer',
			'click .cancel-offer': 'onCancelOffer'
		},
		parameters: {
			tab: '',
			index: 0
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {

			_.bindAll(this, 'beforeRender', 'render', 'afterRender');

			if ( opts !== undefined && _.isObject(opts.parameters) ) {
				this.parameters = $.extend({},this.parameters, opts.parameters);
			};

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			// Init Attributes

			// Events Listener
			this.listenTo( this.model, 'change:state_purchase', this.render );
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );

			this.render();
		},

		/*
		* Render View Element
		*/
		render: function() {

			var attributes = this.model.toJSON();
			attributes['index'] = this.parameters.index;

			this.$el.html( this.template(attributes) );
			return this;

		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function () {
			// body...
		},

		/**
		* Fires after of run render function
		*/
		afterRender: function () {

			// reload plugins
			this.ready();
		},

		/**
		* reload plugins and trigger libraries
		*/
		ready: function () {

			// reflow foundation plugins
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
				$(document).foundation('dropdown', 'reflow');
			}
		},

		/*
		* Remove View Element
		*/
		remove: function(){

			var _this = this;
			this.$el.fadeOut('normal', function (){
				_this.$el.remove();
			});
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function ( target, xhr, opts ) {
			window.Misc.setSpinner( this.$el );
		},

		/**
		* response of the server
		*/
		responseServer: function ( model, resp, opts ) {

			//complete proccess
			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false
			});
		},

		/**
		* Cancel Purchase
		*/
		onCancel: function (e) {
			e.preventDefault();
			var _this = this

			var data = {
				'codigo_compra': this.model.get('codigo_compra'),
				'state_purchase': this.model.get('state_purchase'),
				'cancel_sale': true,
				'_token': $('meta[name="csrf-token"]').attr('content')
			};

			// Confirm cancel
			this.confirmCancel = new app.ConfirmWindow({
				model: this.model,
				parameters: {
					template: _.template( ($('#purchase-confirm-cancel-tpl').html() || '') ),
					titleConfirm : '¡Cancelar la compra!',
					onConfirm: function () {
						var _self = this;

						this.model.save(data, {patch: true, wait:true,
							success: function (model, resp, opts) {
								_this.onEvaluation(e);
							}
						});
					}
				}
			});
			this.confirmCancel.render();
		},

		/**
		* Event for Confirmed Purchase
		*/
		onConfirmed: function (e) {
			e.preventDefault();
			var _this = this

			var data = {
				'codigo_compra': this.model.get('codigo_compra'),
				'state_purchase': this.model.get('state_purchase'),
				'confirmed_sale': true,
				'_token': $('meta[name="csrf-token"]').attr('content')
			};
			this.model.save( data, {patch: true, wait:true,
				success: function (model, resp, opts) {
                    if( model.get('acuerdo_producto') ) {
                        _this.onDeliverables(e);
                    }else {
                        _this.onEvaluation(e);
                    }
				}
			});
		},

		/**
		* get purchase evaluation
		*/
		onEvaluation: function(e){
			e.preventDefault();

			if( !this.model.get('evaluation_purchase') ){
				app.AppRouter.navigate( Route.route( 'marketplace.evaluacion.purchase', {
					tab: this.parameters.tab, purchase: this.model.get('codigo_compra') }),
					{ trigger: true }
				);
			}
		},

		/**
		* get deriverables only innpulsa
		*/
		onDeliverables: function(e){
			e.preventDefault();

			app.AppRouter.navigate( Route.route( 'marketplace.entregables.purchase', {
				tab: this.parameters.tab, purchase: this.model.get('codigo_compra') }),
				{ trigger: true }
			);
		},

		/**
		* confirm purchase offer
		*/
		onConfirmOffer: function (e) {
			e.preventDefault();

			var offerData = {
				'codigo_compra': this.model.get('codigo_compra'),
				'state_purchase': this.model.get('state_purchase'),
				'_token': $('meta[name="csrf-token"]').attr('content'),
				'confirm_offer': true,
				titleConfirm: '¡Aceptar oferta!'
			};

			// Confirm offer
			this.responseOffer(offerData);
		},

		/**
		* cancel purchase offer
		*/
		onCancelOffer: function (e) {
			e.preventDefault();

			var offerData = {
				'codigo_compra': this.model.get('codigo_compra'),
				'state_purchase': this.model.get('state_purchase'),
				'_token': $('meta[name="csrf-token"]').attr('content'),
				'confirm_offer': false,
				titleConfirm: '¡Cancelar oferta!'
			};

			// Cancel offer
			this.responseOffer(offerData);
		},

		/**
		* response to the purchase offer
		* @param offerData Object, offer confirm data
		*/
		responseOffer: function (offerData) {
			offerData || (offerData = {});

			var _this = this,
				optsData = {
					titleConfirm : '¡Confirmar oferta!',
				};

			_.extend(optsData, offerData);

			// Confirm Offer
			this.confirmOffer = new app.ConfirmWindow({
				model: this.model,
				parameters: {
					template: _.template( ($( !offerData.confirm_offer ? '#purchase-cancel-offer-tpl' : '#purchase-confirm-offer-tpl' ).html() || '') ),
					titleConfirm : optsData.titleConfirm,
					onConfirm: function () {
						var _self = this;

						this.model.save(_.omit(offerData, 'titleConfirm'), {
							wait: true,
							patch: true,
							success: function(model, resp) {
								// response success or error
								var type = resp.success ? 'success' : 'alert',
									text = resp.success ?
										(resp.message !== undefined ? resp.message : '...')
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
									'type': type,
									'closeTime': 12000
								};
								_.extend( _self.configAlert, config );

								if( resp.success !== undefined ) {
									window.Misc.showAlertBox( _self.configAlert );
								}

								//complete proccess
								window.Misc.removeSpinner({
									'wrap': _this.$el,
									'direct': false
								});
							}
						});
					}
				}
			});
			this.confirmOffer.render();
		},

		/**
		* hides products user
		*/
		onHide: function (e) {
			e.preventDefault();
			this.confirmHide.render();
		}
	});

})(jQuery, this, this.document);
