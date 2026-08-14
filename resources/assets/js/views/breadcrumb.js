/**
* Class BreadcrumbView of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.BreadcrumbView = Backbone.View.extend({

        tagName: 'ul',
        className: 'breadcrumbs',
        template: _.template( $('#breadcrumb-tp').html() ),

        /**
        * Constructor Method
        */
        initialize : function() {

            //Events Listener
            this.listenTo( this.model, 'change', this.render );
        },

        /*
        * Render View Element
        */
        render: function(){
            var attributes = this.model.toJSON();
            this.$el.html( this.template( attributes ) );
            return this;
        }
    });


})(jQuery, this, this.document);
