/**
* Class EventItemView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://tuproyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EventItemView = Backbone.View.extend({

        tagName: 'li',
        className: 'separator',
        template: _.template( ($('#calendar-item-event-tpl').html() || '') ),
        events: {
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

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();

            this.$el.html( this.template(attributes) );

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
