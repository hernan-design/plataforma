/**
* Class SectionTitleView extend of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo, @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.SectionTitleView = Backbone.View.extend({

        el: '.section-title',
        template: _.template( ($('#section-title-tpl').html() || '') ),

        /**
        * Constructor Method
        */
        initialize : function() {
            this.attributes = { subtitle: undefined };

            this.on('title:subtitle', this.buildTitle);
        },

        /*
        * Render View Element
        */
        render : function(){

            this.$el.html( this.template(this.attributes) );
            return this;
        },

        /**
        * get posts most recent
        */
        buildTitle : function (subtitle) {
            this.attributes.subtitle = subtitle;
            this.render();
        }
    });


})(jQuery, this, this.document);
