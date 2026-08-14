/**
* Class CourseThemesView extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CourseThemesView = Backbone.View.extend({
        tagName: 'dd',
        className: 'accordion-navigation-theme active',
        template: _.template( ($('#course-themes-list-tpl').html() || '') ),
        events: {
            //
        },

        /**
        * Constructor Method
        */
        initialize: function(){

            //Init Attributes
            this.$validateSuscribe = $("#subscription-validate").val();
            // Events Listener
            this.listenTo( this.model, "change", this.render );
        },

        /*
        * Render View Element
        */
        render: function(){

        	var attributes = this.model.toJSON();
            if( _.isObject(this.attributes) && this.attributes.type !== undefined ){
                attributes.type = this.attributes.type;
            }
            attributes.subscrition = this.$validateSuscribe;
            this.$el.append( this.template(attributes));

            return this;
        }

    });

})(jQuery, this, this.document);
