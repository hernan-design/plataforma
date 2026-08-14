/**
* Class UsersEventItemView extends of Backbone View
* @author TuProyecto || Desarrollador : @dortegon
* @link http://tuproyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UsersEventItemView = Backbone.View.extend({
        tagName: 'li',
        className: 'card-data-info separator',
        template: _.template( ($('#inscribed-event-tpl').html() || '') ),
        events: {
            //
        },

        /**
        * Constructor Method
        */
        initialize : function() {
            // Init Attribute
            this.configAlert = {
                'wrapper': this.$el,
                'closeTime': 7000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Init model
            this.userNetworkModel = new app.UserNetworkModel();

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.userNetworkModel, 'change', this.onChangeIcon );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();

            this.$el.html( this.template(attributes) );

            // button send the invitation
            this.userNetworkModel.set({'seg_codigo_usuario': this.model.get('srcparams'), 'nickname_usuario': this.model.get('nickname_usuario'), 'state_friendship' : this.model.get('state_friendship'), 'owner': true });
            this.buttonsfriendlyView = new app.UserButtonsFriendlyView({
                el: this.$('#buttons-contact-pending-friendship'),
                model: this.userNetworkModel,
                parameters: {
                    notemplate: false
                }
            });

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
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });
        }
   });

})(jQuery, this, this.document);
