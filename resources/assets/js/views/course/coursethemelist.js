/**
* Class CourseThemeListView of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CourseThemeListView = Backbone.View.extend({

        el: '#course-content',
        attributes: {
            'viewTheme' : 'CourseThemesView'
        },
        events: {

        },

        /**
        * Constructor Method
        */
        initialize : function(){
            // Init Attributes

            // Events Listener
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );
            this.listenTo( this.collection, 'all', this.render );

            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('accordion', {content_class:'content-theme'});
            }
        },

        /*
        * Render View Element
        */
        render: function(){
            // Init Attributes
            this.$themeCourseData = this.$('.themes-course');

            this.$el.foundation('accordion', 'reflow');

            return this;
        },

        /**
        * Render view theme per model
        * @param Object courseThemeModel Model instance
        */
        addOne: function (courseThemeModel) {
            var view = new app[this.attributes.viewTheme]({
                model: courseThemeModel,
                attributes: (_.isObject(this.attributes) && this.attributes.type != undefined) ? {type: this.attributes.type} : {}
            });

            this.$themeCourseData.append( view.render().el );
        },

        /**
        * Render all view category of the collection
        */
        addAll: function () {
            this.$themeCourseData.html();
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });
        }

   });

})(jQuery, this, this.document);
