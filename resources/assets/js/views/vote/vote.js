/**
* Class CourseView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.VoteUserView = Backbone.View.extend({

        el: '.content-form-vote',
        events: {
            'submit #form-user-vote': 'onSendUserVote',
        },
        parameters: {

        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            // extends parameters
			if( opts.parameters !== undefined && _.isObject(opts.parameters) )
            this.parameters = $.extend({}, this.parameters, opts.parameters);

            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            this.configAlert = {
				'wrapper': '#main-wrap',
				'closeTime': 6000,
				'speedOpen': 500,
				'speedClose': 500
			};

            // Init Attribute
            this.$modalUserVote = $('#modal-user-vote');

            // Events Listener

            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function() {
            this.$modalUserVote.foundation('reveal','open');
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

        },

        onSendUserVote: function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var _this = this;
            data = window.Misc.formToJson(e.target);
            data.entity = this.parameters.entity;
            captchaResponse = grecaptcha.getResponse();

            dataAuth =
            {
                correo_electronico: 'MG4rZ25EUnRLc01ZcEZNVFVDS25NNTM4WWMrNjFSUzJQRHZMY3hlQzVqOD06OgAAAAAAAAAAAAAAAAAAAAA=',
                password: 'VzB0WkNTYUNXYVgya3lWUkVPblA3UT09OjoAAAAAAAAAAAAAAAAAAAAA'
            };

            window.Misc.setSpinner( this.$el );

            // console.log('Route', document.url + '/api/login');

            if (captchaResponse != '') {

                $.post(document.url + '/api/login', dataAuth, function(resp) {
                    if (resp.token) {
                        var route = document.url + Route.route('api.voto.store') + '?token=' + resp.token;
                        $.post(route, data, function(resp) {

                            window.Misc.removeSpinner({
                                'wrap': _this.$el,
                                'direct': true
                            });

                            if (resp.success !== undefined) {
                                if (resp.success) {
                                    if (resp.vote) {
                                        window.Misc.redirect( app.AppRouter.navigate( Route.route('voto.verify', { vote: resp.vote }) ) )
                                    }
                                } else {
                                    conf = {
                                        text: resp.error,
                                        type: 'alert'
                                    }

                                    confAlert = $.extend({}, _this.configAlert, conf);
                                    window.Misc.showAlertBox( confAlert );
                                }
                            }
                        });
                    }
                });
            } else {
                window.Misc.removeSpinner({
                    'wrap': _this.$el,
                    'direct': true
                });

                conf = {
                    text: 'El recaptcha es obligatorio !',
                    type: 'alert'
                }

                confAlert = $.extend({}, _this.configAlert, conf);
                window.Misc.showAlertBox( confAlert );
            }
        }
   });
})(jQuery, this, this.document);
