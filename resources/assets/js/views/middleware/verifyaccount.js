/**
* Class VerifyAccountView of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.VerifyAccountView = Backbone.View.extend({

        el: '#verify-account-content',
        events: {
            'submit #form-forward-confirm': 'onFordwardConfirm'
        },

        /**
        * Constructor Method
        */
        initialize: function(){
            _.bindAll(this, 'onSuccessFordwardConfirm' );
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

            return this;
        },

        /**
        * post data by user confirm
        */
        onFordwardConfirm: function (e) {

            e.preventDefault();
            var data = window.Misc.formToJson( e.target );

            window.Misc.setSpinner( this.$el );
            $.post(document.url + Route.route('usuario.confirmacion.email'), data, this.onSuccessFordwardConfirm);
        },

        /**
        * success event for fordward confirm
        * @param Object res
        */
        onSuccessFordwardConfirm: function (resp) {
            window.Misc.removeSpinner({
               'wrap': this.$el,
               'direct': true
            });

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
            var confAlert = {
                'text': text,
                'type': type
            };
            _.extend( this.configAlert, confAlert );

            if( resp.success !== undefined ){
                if( resp.success ){
                    window.Misc.showAlertBox( this.configAlert );
                }else {
                    window.Misc.showAlertBox( this.configAlert );
                }
            }
        }
    });
})(jQuery, this, this.document);
