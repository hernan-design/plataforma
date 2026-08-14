/**
* Class MarketPlacePurchaseView extends of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {} );

(function ($, window, document, undefined) {

    app.MarketPlacePurchaseView = Backbone.View.extend({

        el: '#marketplace-content',
        template: _.template( ($('#marketplace-purchase-tpl').html() || '') ),
        events: {
        	'submit #form-purchase-order': 'onStore'
        },
        parameters: {
           dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            if(!_.isUndefined(opts) && _.isObject(opts.parameters))
                this.parameters = $.extend({},this.parameters, opts.parameters);

            //Init Attribute
            this.purchaseModel = new app.PurchaseModel();

            if(!_.isEmpty(this.parameters.dataFilter.purchase)){
                _this = this;
                this.purchaseModel.idAttribute = 'codigo_compra';
                this.purchaseModel.set( {'codigo_compra': this.parameters.dataFilter.purchase}, {'silent':false} );
                this.purchaseModel.fetch({ success: function () {
                        _this.render();
                } });



            }



            this.configAlert = {
                'wrapper': '#main-wrap',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
        	this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );

        	this.listenTo( this.purchaseModel, 'request', this.loadSpinner );
        	this.listenTo( this.purchaseModel, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            attributes.quantity = this.parameters.dataFilter.quantity || 0;
            attributes.oferta = this.purchaseModel.get('valor_total_compra') || 0;
            console.log(attributes);
            this.$el.html( this.template(attributes) );

            // Initilize attributes
            this.$fldQuantity = this.$('#quantity-buy');

            // reload plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
            }

            if( typeof(window.initComponent.spinnerTrigger) == 'function' && _.has($.fn, 'sspinner') ){
                window.initComponent.spinnerTrigger();

                // validate product quantity
                this.$fldQuantity.sspinner('option', 'max', this.model.get('cantidad_producto') );

                // if( parseInt(this.model.get('cantidad_producto')) <= 0 )
                //     this.$fldQuantity.spinner('option', 'disabled', true );
            }

            if( typeof window.initComponent.configEllipsis == 'function' && _.has($.fn, 'dotdotdot') )
            	window.initComponent.configEllipsis();

            return this;
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
 			window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            // response success or error
			var text = resp.success ? '' : resp.errors,
			type = resp.success ? 'success' : 'alert';

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
                'wrap': this.$el,
                'direct': false,
                'callback': (function (conf, re, _this) {
                    return function () {
                        if(!_.isUndefined(re.success)) {
	                        if( re.success ){
                                var data = {
                                    shipping: re.codigo_compra,
                                    purchase: re.codigo_compra
                                };

                                if(!_.isEmpty(re.promotion_code)){
                                    data.promotion_code = re.promotion_code
                                }


                                window.Misc.redirect( window.Misc.urlFull(Route.route( re.redirect, data)) );
                                return;
	                        }
	                   		window.Misc.showAlertBox( conf );
	                   	}
                    }
                })(this.configAlert, resp, this)
            });
        },

        /**
        * Event Create Purchase Order
        */
        onStore: function (e) {
            e.preventDefault();
            var _this = this
            var data = window.Misc.formToJson( e.target );
            data.codigo_producto = this.model.get('codigo_producto');
            nombre_producto = this.model.get('nombre_producto');

            if(!_.isEmpty(this.parameters.dataFilter['promotion_code'])){
                data.promotion_code = this.parameters.dataFilter['promotion_code'];
            }

            if(!_.isEmpty(this.parameters.dataFilter['purchase'])){
                data.purchase = this.parameters.dataFilter['purchase'];
            }

            this.confirmOffer = new app.ConfirmWindow({
                model: this.model,
                parameters: {
                    template: _.template( ($('#purchase-store-confirm-tpl').html() || '') ),
                    titleConfirm : 'Compra de "' + nombre_producto + '"' ,
                    onConfirm: function () {
                        var purchase_url = window.Misc.urlFull(Route.route('marketplace.compras.store'));
                        _this.purchaseModel.save( data, { wait:'true', type:'post', url:purchase_url} );

                    }
                }
            });
            this.confirmOffer.render();
        },
   });

})(jQuery, this, this.document);
