/**
* Class ArticleListView extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ArticleListView = Backbone.View.extend({

        el: '#content-articles-list',
        events: {

        },
        parameters: {
            'category': null
        },
        dataFilter: {},

        /**
        * Constructor Method
        */
        initialize: function(){

            var _this = this;

            _.bindAll(this, 'onLoadMore');

            // Events Listener
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );
            this.on('getdata', this.getFirstData);

            $( window ).on("scroll", this.onLoadMore);
        },

        /*
        * Render View Element
        */
        render: function () {

            //Init Attributes
            this.$noResults = this.$('.no-results-filter');
            this.$wrapperData = this.$('#article-list');
            this.$spinnerBlogs = $('<div>').attr('id','spinner-load-posts');

            // hide no results message
            if( this.collection.length )
                this.$noResults.css('display', 'none');

            return this;
        },

        /**
        * get reset data
        *
        */
        getFirstData: function  () {

            this.collection.getFirstPage( {reset:true, data: this.dataFilter} );
            this.pageOld = this.collection.state.currentPage;

            $(window).scrollTop(0);
        },

        /**
        * Render view article by model
        * @param Object blogArticleModel Model instance
        */
        addOne: function (blogArticleModel) {

            // add view from the zero index
            if( this.collection.indexOf(blogArticleModel) > 0 ){
                var view = new app.ArticleItemView({
                    model: blogArticleModel
                });

                if( blogArticleModel.isNew() ){
                    this.$wrapperData.prepend( view.render().el );
                }else{
                    this.$wrapperData.append( view.render().el );
                }
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

            this.$noResults.css('display', 'none');

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
        },

        /**
        * load more posts
        */
        onLoadMore: function (e) {

            e.preventDefault();

            var _this = this;
            var scrollHeight = $(document).height();
            var scrollPosition = $(window).height() + $(window).scrollTop();

            if ((scrollHeight - scrollPosition) / scrollHeight <= 0.001) {
                // when scroll to bottom of the page
                if( this.collection.state.currentPage < this.collection.state.lastPage && this.pageOld == this.collection.state.currentPage ){
                    this.collection.getNextPage({
                        data: this.dataFilter,
                        wait: true,
                        success: function (collection) {
                            _this.pageOld = collection.state.currentPage;
                        }
                    });
                }
            }
        }
    });

})(jQuery, this, this.document);
