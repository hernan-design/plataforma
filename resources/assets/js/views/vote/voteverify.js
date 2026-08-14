/**
* Class CourseView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.VoteVerifyView = Backbone.View.extend({

        el: '#verify_vote',
        events: {
            'submit #form-verify-vote': 'onVerifyVote',
            'click .re-send-vote':'onReSendUserVote'
        },
        parameters: {
            _redirect: false
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            console.log("VoteVerifyView initialized!");
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

            // Events Listener

            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function() {
            //
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

        onVerifyVote: function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var _this = this;
            data = window.Misc.formToJson(event.target);
            data.vote = this.parameters.vote;

            $.post(document.url + Route.route('api.voto.verifycode'), data, function(resp) {
                if (resp.success !== undefined) {
                    if (resp.success) {
                        conf = {
                            text: resp.message,
                            type: 'success'
                        }

                        confAlert = $.extend({}, _this.configAlert, conf);
                        window.Misc.showAlertBox( confAlert );
                    } else {
                        conf = {
                            text: resp.message,
                            type: 'alert'
                        }

                        confAlert = $.extend({}, _this.configAlert, conf);
                        window.Misc.showAlertBox( confAlert );
                    }
                }
            });
        },

        onReSendUserVote: function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var _this = this;

            data = {};
            data.type = $(e.target).data('type');
            data.vote = this.parameters.vote;

            window.Misc.setSpinner( this.$el );

            $.post(document.url + Route.route('api.voto.resend'), data, function(resp) {

                window.Misc.removeSpinner({
                    'wrap': _this.$el,
                    'direct': true
                });

                if (resp.success !== undefined) {
                    if (resp.success) {
                        if (resp.vote) {
                            conf = {
                                text: resp.message,
                                type: 'success'
                            }

                            confAlert = $.extend({}, _this.configAlert, conf);
                            window.Misc.showAlertBox( confAlert );
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
})(jQuery, this, this.document);
