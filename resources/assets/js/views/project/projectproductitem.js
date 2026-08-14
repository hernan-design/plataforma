/**
* Class ProjectProductItemView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProjectProductItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#project-product-item-list-tpl').html() || '') ),
        events: {
        },
        dataFilter: {},

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

            this.buttonsActions = this.$('#buttons-marketplace-product-action');

            this.buttonsMarketPlace = new app.MarketPlaceProductActionsView({
                el: this.buttonsActions,
                model: this.model,
                parameters: {
                    'type_action': 'state'
                }
            });

            return this;
        }
    });

})(jQuery, this, this.document);
