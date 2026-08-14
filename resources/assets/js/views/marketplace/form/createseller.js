/**
* Class MarketPlaceCreateSellerView extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MarketPlaceCreateSellerView = Backbone.View.extend({

        el: '#content-create-seller',
        template: _.template( ($('#marketplace-create-seller-tpl').html() || '') ),
        events:{
            'submit #form-create-seller': 'onStore',
        },

        /**
        * Constructor Method
        */
        initialize : function(){

            //Init Attributes
            this.configAlert = {
                'wrapper': this.$el,
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = {};
            this.$el.html( this.template(attributes) );

            // trigger libraries
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
            }
            // reload plugins
            if( typeof window.initComponent.initConfigForm == 'function' )
            	window.initComponent.initConfigForm();

            return this;
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {

            window.Misc.setSpinner( this.$el );
        },

        /*
        * Post seller with Jquery
        */
        onStore: function(e){
            e.preventDefault();
            this.loadSpinner();

            var _this = this;
            $.ajax({
                type: "POST",
                url: window.Misc.urlFull( Route.route('marketplace.ventas.store') ),
                data: $('#form-create-seller').serialize(),
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
                                if(!resp.success){
                                    window.Misc.showAlertBox( conf );
                                }else{
                                    url = document.url + Route.route("marketplace.create");
                                    return window.Misc.redirect(url);
                                }
                            }
                        })(_this.configAlert, data)
                    });
                }
            });
        }
   });

})(jQuery, this, this.document);
