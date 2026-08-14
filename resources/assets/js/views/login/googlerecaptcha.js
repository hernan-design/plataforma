/**
* Class GoogleRecaptchaView extends of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.GoogleRecaptchaView = Backbone.View.extend({

        el: '.content-form-login',
        /**
        * Constructor Method
        */
        initialize : function() {
            var _this = this;
            //Init Attributes
            this.configAlert = {
                'wrapper': '.login-alert-display',
                'closeTime': 6000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Google recaptcha
            if( this.$('.widget-login-recaptcha').length && !this.$('.widget-vote-recaptcha').length && !window.Misc.checkSession(false) )
            {
                var widgetGRecaptcha = this.$('.widget-login-recaptcha')[0];
                setTimeout(function() {
                    grecaptcha.render(widgetGRecaptcha, {
                        'sitekey' : $(widgetGRecaptcha).data('key-recaptcha'),
                        'size': 'invisible',
                        'callback' : this.onLogin
                    })
                }.bind(this), 100)
            }

            // Google recaptcha vote

            if ( this.$('.widget-vote-recaptcha').length ) {
                var widgetGRecaptchaVote = this.$('.widget-vote-recaptcha')[0];
                setTimeout(function() {
                    grecaptcha.render(widgetGRecaptchaVote, {
                        'sitekey' : $(widgetGRecaptchaVote).data('key-recaptcha'),
                        'callback' : this.onVote,
                        'error-callback': this.onError
                    })
                }.bind(this), 100)
            }
        },

        /*
        * Render View Element
        */
        render: function() {
            //
        },

        /*
        * Event onLogin
        */
        onLogin: function(token) {
            // Google recaptcha
            this.$('#form-login-email').submit();
        },

        /**
         * Error
         */
        onError: function() {
            console.log('On error');
        },

        /**
         * Send vote
         */
        onVote: function(token) {
            // Google recaptcha
            this.$('#form-user-vote').submit();
        }
    });


})(jQuery, this, this.document);
