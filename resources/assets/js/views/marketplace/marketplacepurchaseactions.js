/**
* Class MarketPlacePurchaseActionsView extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MarketPlacePurchaseActionsView = Backbone.View.extend({
		className: 'icons-connect',
		template: _.template( ($('#buttons-purchases-tpl').html() || '') ),
		events: {
			'click .cancel-purchase': 'onCancel',
			'click .confirm-purchase': 'onConfirmed',
			'click .deriverables-purchase': 'onDeliverables',
			'click .evaluation-purchase': 'onEvaluation',
			'click .cancellation-reason': 'onEvaluation',
            'click .general-evaluation-purchase': 'onGeneralEvaluation',
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

			// Render
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

			var _this = this;
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
				'cancel_purchase': true,
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
				'confirmed_purchase': true,
				'_token': $('meta[name="csrf-token"]').attr('content')
			};

			this.model.save( data, {patch: true, wait:true,
				success: function (model, resp, opts) {
                    if( model.get('acuerdo_producto') ) {
                        _this.onDeliverables(e);
                    }else{
                        _this.onEvaluation(e);
                    }
				}
			} );
		},

		onEvaluation: function(e){
			e.preventDefault();

			if( !this.model.get('evaluation_purchase') ){
				app.AppRouter.navigate( Route.route( 'marketplace.evaluacion.purchase', {
					tab: this.parameters.tab,
                    purchase: this.model.get('codigo_compra')
                }),{
                    trigger: true
                });
			}
		},

        onGeneralEvaluation: function(e){
            e.preventDefault();

            if( !this.model.get('evaluation_purchase') ){
                app.AppRouter.navigate( Route.route( 'marketplace.general.evaluacion.purchase', {
                    purchase: this.model.get('codigo_compra')
                }),{
                    trigger: true
                });
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
		* hides products user
		*/
		onHide: function (e) {
			e.preventDefault();
			this.confirmHide.render();
		}
	});

})(jQuery, this, this.document);
