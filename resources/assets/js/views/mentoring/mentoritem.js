/**
* Class MentorItemView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MentorItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#mentor-item-tpl').html() || '') ),
        events: {

        },
        parameters: {
            'rol': ''
        },

        /**
        * Constructor Method
        */
        initialize: function(opts){

            //Init Attributes
            if( opts !== undefined && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            // Events Listener
            this.listenTo( this.model, "change", this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            attributes.rol = this.parameters['rol'];
            
            this.$el.html( this.template(attributes) );

            if( _.has($.fn, 'foundation') )
                $(document).foundation('dropdown', 'reflow');

            return this;
        }

    });

})(jQuery, this, this.document);