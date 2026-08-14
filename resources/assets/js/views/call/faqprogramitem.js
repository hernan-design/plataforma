/**
* Class FaqProgramItemView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.FaqProgramItemView = Backbone.View.extend({
        // tagName: 'li',
        template: _.template( ($('#program-faq-list-tpl').html() || '') ),
        events: {
            //
        },

        /**
        * Constructor Method
        */
        initialize: function(){

            //Init Attributes

            // Events Listener
            this.listenTo( this.model, "change", this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            return this;
        }

    });

})(jQuery, this, this.document);
