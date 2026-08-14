/**
* Class UserMessageContactView extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserMessageContactView = Backbone.View.extend({
        
        template: _.template( ($('#user-message-contact-tpl').html() || '') ),
        events: {
            'submit #form-message-contact': 'onStore'
        },
        parameters: {
            user: ''
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            _.extend(this.parameters, opts.parameters);

            //Init Attributes
            this.$modalBase = $('#modal-base-message-tp');
            this.configAlert = {
                'wrapper': '#modal-base-message-tp',
                'closeTime': 7000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, "request", this.loadSpinner );
            this.listenTo( this.model, "sync", this.responseServer );

        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = {};
            attributes.codigo_usuario = this.parameters['user'];

            this.$el.html( this.template(attributes) );

            //Init Attributes
            this.$formCreate = this.$('#form-message-contact');

            if( _.has($.fn, 'foundation') )
                this.$el.foundation('abide');

            return this;
        },

        /**
        * Event for create request mentory
        */
        onStore: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target );

            this.model.save( data, {patch: true, wait:true} );

            this.$formCreate.find(':submit').addClass('disabled');
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            // window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function (model, resp, opts) {

            // response success or error
            var type = resp.success ? 'success' : 'alert',
                text = resp.success ? 
                    (resp.message !== undefined ? resp.message : '')
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
                'wrap': this.$el,
                'direct': false,
                'callback': (function (conf, re, $formReset) {
                    return function () {
                        $formReset.find(':submit').removeClass('disabled');

                        if( re.success && re.success !== undefined ){

                            $formReset[0].reset();

                        }else if( !re.success && re.success !== undefined ){

                            window.Misc.showAlertBox( conf );
                        }
                    };
                })(this.configAlert, resp, this.$formCreate)
            });

            if( resp.success ){
                this.$modalBase.foundation('reveal', 'close');
            }
        }
    });

})(jQuery, this, this.document);