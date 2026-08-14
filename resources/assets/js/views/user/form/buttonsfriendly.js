/**
* Class UserButtonsFriendly extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserButtonsFriendlyView = Backbone.View.extend({
        className: 'icons-connect',
        template: _.template( ($('#buttons-friendly-user-tpl').html() || '') ),
        events: {
            'click .network-user': 'onNetworkUser',
            'click .cancel-network-user': 'onCancel',
            'click .hide-friendship-user': 'onHide',
            // 'click .message-friendship-user': 'onMessage'
        },
        parameters: {
            'type_action': '',
            'userprofile': '',
            'notemplate': true
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {

            if ( opts !== undefined && _.isObject(opts.parameters) ) {
                this.parameters = $.extend({},this.parameters, opts.parameters);
            };

            // Init Attributes
            this.confirmHide = new app.UserContactConfirmHideView({
                model:this.model,
                parameters: {
                    'srcparams-user': this.model.get('seg_codigo_usuario'),
                    'state_friendship': this.model.get('state_friendship')
                }
            });

            // this.userDiscussionModel = new app.UserDiscussionModel();

            this.$modalBase = $('#modal-base-message-tp');
            this.$modalBase.find('.inner-title-modal').html('Mensaje Contacto').attr('area-title');

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );

            // Render
            this.render();
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            attributes.type_action = this.parameters['type_action'];

            if(this.parameters.notemplate){

                this.$el.html( this.template(attributes) );

                // reload plugins
                if( _.has($.fn, 'foundation') ) {
                    $(document).foundation('dropdown', 'reflow');
                    $(document).foundation('tooltip', 'reflow');
                }

                return this;
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
        * Event for register User Network
        */
        onNetworkUser: function (e) {

            e.preventDefault();

            var data = {
                'srcparams-user': this.model.get('seg_codigo_usuario'),
                'state_friendship': this.model.get('state_friendship'),
                '_token': $('meta[name="csrf-token"]').attr('content')
            };

            this.model.save( data, {patch: true, wait:true} );
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
        * Cancel contact user
        */
        onCancel: function (e) {
            e.preventDefault();

            var data = {
                'srcparams-user': this.model.get('srcparams-user'),
                'state_friendship': this.model.get('state_friendship'),
                'cancel_friendship': true,
                '_token': $('meta[name="csrf-token"]').attr('content')
            };

            this.model.save( data, {patch: true, wait:true} );
        },

        /**
        * hides contacts user
        */
        onHide: function (e) {
            e.preventDefault();
            this.confirmHide.render();
        },

        /**
        * Message contact user
        */
        // onMessage: function (e) {

        //     if( e !== undefined)
        //         e.preventDefault();

        //     var messageContact = new app.UserMessageContactView({
        //         model:this.userDiscussionModel,
        //         parameters: {
        //             'user': this.parameters['userprofile']
        //         }
        //     });

        //     this.$modalBase.find('.content-modal').html( messageContact.render().el );
        //     this.$modalBase.foundation('reveal', 'open');
        // }
    });

})(jQuery, this, this.document);
