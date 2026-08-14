/**
* Class UserTeamItemView extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserTeamItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#team-item-list-tpl').html() || '') ),
        events: {
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
            if( _.isObject(this.attributes) && this.attributes.viewShow !== undefined ){
                attributes.viewShow = this.attributes.viewShow;
            }
            
            this.$el.html( this.template(attributes) );

            if( _.has($.fn, 'foundation') )
                $(document).foundation('dropdown', 'reflow');

            return this;
        }
    });

})(jQuery, this, this.document);