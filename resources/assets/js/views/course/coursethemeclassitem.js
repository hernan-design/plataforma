/**
* Class CourseThemeClassItemView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CourseThemeClassItemView = app.CourseThemeBase.extend({

        tagName: 'dd',
        className: 'accordion-navigation-theme',
        template: _.template( ($('#course-theme-class-item-list-tpl').html() || '') ),
        events: {
        	'click .link-to-theme-video': 'onFiresVideo'
        },

        /**
        * Constructor Method
        */
        initialize: function(){
            //Init Attributes
            this.attachments = new app.CourseThemeAttachedList();

            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'change:adjuntos', this.setAttachments );
            this.listenTo( this.attachments, 'add', this.addOneAttached );
            // this.listenTo( this.attachments, 'reset', this.addAllAttached );
            this.listenTo( this.model, 'active', this.activeTheme );
            //this.listenTo( this.model, 'sync', this.responseServer );
        },

        /**
        * fires video for player
        */
        onFiresVideo: function (e) {
            e.preventDefault();

            var $linkVideo = $(e.currentTarget),
                lecture = $linkVideo.data('lecture');

            app.AppRouter.navigate( $linkVideo.attr('href'), {trigger: false} );

            var lectureVideo = this.getLecture(lecture);
            this.model.collection.trigger('changeVideo', lectureVideo, this.model);
        },

        /**
        * get lecture object of theme
        * @param lecture
        */
        getLecture: function(lecture) {
            return _.findWhere(this.model.get('adjuntos'), {url_adjunto: lecture});
        },

        /**
        * active theme on list
        * @param Object theme
        * @parama Array lecture
        */
        activeTheme: function (theme, lecture) {

            this.$el.find('> a').trigger('click.fndtn.accordion');

            if( lecture !== undefined ) {
                this.$el.parents('.themes-course')
                        .find('[data-lecture]')
                            .parent().removeClass('active');

                this.$el.find('[data-lecture="'+ lecture.url_adjunto +'"]')
                        .parent().addClass('active');
            }
        }
    });

})(jQuery, this, this.document);
