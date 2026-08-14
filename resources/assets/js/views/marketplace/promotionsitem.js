/**
* Class PromotionsItemView extends of Backbone View
* @author TuProyecto || Desarrolladora : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.PromotionsItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#my-promotions-item-list-tpl').html() || '') ),
        events: {
            //
        },

        /**
        * Constructor Method
        */
        initialize: function() {

            // Events Listener
            this.listenTo( this.model, "change:codigo_promocion", this.render );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            return this;
        }
    });

})(jQuery, this, this.document);
