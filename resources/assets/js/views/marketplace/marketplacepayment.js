/**
* Class MarketplacePaymentView extends of Backbone View
* @author TuProyecto || Desarrollador : @xidnykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MarketplacePaymentView = Backbone.View.extend({
        el: '#content-purchase-marketplace',
        events: {
            'click .payment-type': 'onPayment'
        },
        parameters: {
            'purchase' : 'purchase',
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

        	// extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);
            // Init

            this.configAlert = {
                'wrapper': this.$el,
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {

            window.Misc.setSpinner( this.$el );
        },

        /**
        * event Payment
        */
        onPayment: function (e) {

            var payment = $(e.currentTarget).val(),
            	_this = this;

       		this.loadSpinner();
            $.ajax({
                type: "GET",
                url: window.Misc.urlFull( Route.route('marketplace.compras.validvoucher', {purchase: _this.parameters.purchase}) ),
                data: { payment: payment },
                dataType: "json",
                success: function (data ) {
                    // response success or error
                    var text = data.success ? '' : data.errors,
                    type = data.success ? 'success' : 'alert';

                    if( _.isObject( data.errors ) ){

                        var listError = '<ul>';

                        $.each(data.errors, function(field, item) {
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

                    // complete proccess
                    window.Misc.removeSpinner({
                        'wrap': _this.$el,
                        'direct': false,
                        'callback': (function (conf, resp) {
                            return function () {
                                if(resp.success) {
                                    $('#form-purchase-payment').find(':submit').removeClass('disabled');
                                }else{
                                    window.Misc.showAlertBox( conf );
                                    $('#form-purchase-payment').find(':submit').addClass('disabled');
                                }
                            }
                        })(_this.configAlert, data)
                    });
                }
            });
        }
    });

})(jQuery, this, this.document);
