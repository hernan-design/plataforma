/**
* Class StepChannelsView extends of Backbone View
* @author TuProyecto || Desarrolladora : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.StepChannelsView = Backbone.View.extend({

        el: '#social-community-channels-form',
        events: {
            'submit #form-user-channels': 'onStore'
        },
        parameters: {
           //
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            // extends parameters
            if( opts.parameters !== undefined && _.isObject(opts.parameters) )
                _.extend(this.parameters, opts.parameters);

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

        onStore: function (e) {
            e.preventDefault();

            var _this = this,
                data = window.Misc.formToJson( e.target );

            this.loadSpinner();
            $.post( window.Misc.urlFull( Route.route('comunidad.canalusuario.index') ), data, function( resp ) {

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
                _.extend( _this.configAlert, config );

                //complete proccess
                window.Misc.removeSpinner({
                    'wrap': this.$el,
                    'direct': false,
                    'callback': (function (conf, re, _this) {
                        return function () {
                            if(re.success != undefined) {
                                if( re.success ){
                                    window.Misc.redirect( re.redirect )
                                }else{
                                    window.Misc.showAlertBox( conf );
                                }
                            }
                        }
                    })(_this.configAlert, resp, _this)
                });
            });
        }
   });

})(jQuery, this, this.document);
