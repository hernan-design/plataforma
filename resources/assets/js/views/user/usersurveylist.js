/**
* Class UserSurveyListView extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserSurveyListView = Backbone.View.extend({

        el: '#user-surveys',
        events: {

        },

        /**
        * Constructor Method
        */  
        initialize: function(){
            //Init Attributes
            this.$noResults = this.$('.no-results-filter');
            this.$wrapPagination = this.$('.wrap-pagination');
            this.$wrapperData = this.$('.browse-list-surveys');

            // Events Listener
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );
        },

        /*
        * Render View Element
        */
        render: function () {

            var _this = this;

            this.$wrapPagination.each(function(index, el) {
                var pagination = new app.Paginator({
                    className: 'right pagination inner-title-section',
                    collection: _this.collection,
                    attributes: {
                        data: {'srcparams-user':_this.attributes['srcparams-user']}
                    }
                });

                $(el).html( pagination.render().el );
            });
            
            return this;
        },

        /**
        * Render view theme by model
        * @param Object themeModel Model instance
        */
        addOne: function (projectModel) {
            var view = new app.UserSurveyItemView( {model: projectModel} );
            this.$wrapperData.append( view.render().el );
        },

        /**
        * Render all view theme of the collection
        */
        addAll: function () {
            this.$wrapperData.html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function (target, xhr, opts) {
            window.Misc.setSpinner( this.$el );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {

            if( !target.length )
                this.$noResults.fadeIn('fast');
            
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });
        }
    });

})(jQuery, this, this.document);