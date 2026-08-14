/**
* Class CourseThemeItemView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CourseThemeItemView = app.CourseThemeBase.extend({
        tagName: 'dd',
        className: 'accordion-navigation-theme',
        template: _.template( ($('#course-theme-item-list-tpl').html() || '') ),

        /*
        * Render View Element
        */
        render: function(){

            // console.log( this.model );
            var attributes = this.model.toJSON();
            if( _.isObject(this.attributes) && this.attributes.type !== undefined ){
                attributes.type = this.attributes.type;
            }

            this.$el.html( this.template(attributes) );

            //Init Attributes
            this.$attachedList = this.$('.attached-list-theme');

            // Set Attachments
            this.setAttachments();

            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('accordion', 'reflow');
            }

            // active if it is first theme
            if( this.model.collection.indexOf( this.model ) == 0 ) {
                // this.$el.find('> a').trigger('click.fndtn.accordion');
                this.$el.addClass('active');
                this.$('.content-theme').addClass('active');
            }

            return this;
        }

    });

})(jQuery, this, this.document);
