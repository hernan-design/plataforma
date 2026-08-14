/**
* Class UserWallPostListView of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserWallPostListView = Backbone.View.extend({

        el: '#user-wall',
        events: {
            // 'click .load-posts': 'onLoadMore'
        },

        /**
        * Constructor Method
        */
        initialize : function(){
            _.bindAll(this, 
                'onLoadMore');

            //Init Attributes
            this.wallPostCreate || (this.wallPostCreate = null);
            this.$formCreate = this.$('#form-post-wall-user');
            this.$postsWrap = this.$('#wall-posts-wrap');
            this.$noResults = this.$('.no-results-filter');
            this.$spinnerPosts = $('<div>').attr('id','spinner-load-posts');
            this.pageOld = this.collection.state.currentPage;

            this.dataFilter = {};
            this.dataFilter.wall = 'user';
            this.dataFilter['srcparams-user'] = this.attributes['srcparams-user'];

            // Events Listener
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'store', this.storeOne );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);
            this.listenTo( this.collection, 'all', this.render);
            this.on('getdata', this.getFirstData);

            $( window ).on("scroll", this.onLoadMore);
        },

        /*
        * Render View Element
        */
        render: function(){

            if( this.collection.length )
                this.$noResults.css('display', 'none');
        },

        /**
        * Render view comment by model
        * @param Object categoryModel Model instance
        */
        addOne: function (postModel) {

            var view = new app.UserWallPostView( {model:postModel} );
            view['wallPostCreate'] = this.wallPostCreate;

            if( postModel.isNew() ){
                this.$postsWrap.prepend( view.render().el );
            }else{
                this.$postsWrap.append( view.render().el );
            }
        },

        /**
        * Render all view comment of the collection
        */
        addAll: function () {

            this.$postsWrap.html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * stores a forum comment
        * @param form element
        */
        storeOne: function ( data ) {

           this.collection.create( data, {patch: true} );
           this.$formCreate.find(':submit').addClass('disabled');
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {

            this.$noResults.css('display', 'none');

            if( Backbone.Collection.prototype.isPrototypeOf(target) ){
                this.$spinnerPosts.appendTo( this.$postsWrap );
            }else{
                this.$spinnerPosts.prependTo( this.$postsWrap );
            }
            window.Misc.setSpinner( this.$spinnerPosts );
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
                })(this.$spinnerPosts)
            });

            this.$formCreate.find(':submit').removeClass('disabled');
        },

        /**
        * get reset data
        *
        */
        getFirstData: function  () {
            this.collection.getFirstPage( {reset:true, data: this.dataFilter} );
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
