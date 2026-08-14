/**
* Class MostViewedArticleListView extend of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MostViewedArticleListView = Backbone.View.extend({

        el: '#content-mostviewed-list',
        events: {

        },
		parameters: {
            'category': '',
            'mostView': ''
        },
        /**
        * Constructor Method
        */
        initialize: function(opts){

            // Extend options parameters
            if( opts !== undefined && _.isObject(opts.parameters) ){
                this.parameters = _.extend({}, this.parameters, opts.parameters);
            }

            var _this = this;

            // Events Listener
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );
            this.on('getdata', this.getFirstData);

        },

        /*
        * Render View Element
        */
        render: function () {

            //Init Attributes
            this.$noResults = this.$('.no-results-filter');
            this.$wrapperData = this.$('#most-viewed-articles');
            this.$spinnerBlogs = $('<div>').attr('id','spinner-load-posts');

            // hide no results message
            if( this.collection.length )
                this.$noResults.css('display', 'none');

            // to fire plugins
            if( typeof window.initComponent.configSticky == 'function' && _.has($.fn, 'sticky') )
                window.initComponent.configSticky();

            if( typeof window.initComponent.configScrollbar == 'function' && _.has($.fn, 'perfectScrollbar') )
                window.initComponent.configScrollbar();

            return this;
        },

        /**
        * get reset data
        *
        */
        getFirstData: function  () {

            this.collection.fetch( {reset:true, data: {'typeData':'mostViewed', 'category': this.parameters['category']}} );
        },

        /**
        * Render view article by model
        * @param Object blogArticleModel Model instance
        */
        addOne: function (blogArticleModel) {

            var view = new app[this.parameters['mostView']]({
                model: blogArticleModel
            });

            if( blogArticleModel.isNew() ){
                this.$wrapperData.prepend( view.render().el );
            }else{
                this.$wrapperData.append( view.render().el );
            }
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
            //window.Misc.setSpinner( this.$el );

            if( Backbone.Collection.prototype.isPrototypeOf(target) ){
                this.$spinnerBlogs.appendTo( this.$el );
            }else{
                this.$spinnerBlogs.prependTo( this.$el );
            }
            window.Misc.setSpinner( this.$spinnerBlogs );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {

            if( !target.length )
                this.$noResults.fadeIn('fast');

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false,
                'callback': (function ($elSpinner) {
                    return function () {
                        $elSpinner.remove();
                    };
                })(this.$spinnerBlogs)
            });
        }
    });

})(jQuery, this, this.document);
