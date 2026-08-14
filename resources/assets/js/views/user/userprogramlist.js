/**
* Class UserProductListView of Backbone View
* @author TuProyecto || Desarrollador : @backend01
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserProgramListView = Backbone.View.extend({

        el: '#user-product',
        events: {
            //
        },
        parameters: {
            dataFilter: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            _.bindAll(this, 'onLoadMore');

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            //Init Attributes
            this.pageOld = this.collection.state.currentPage;
            this.$spinnerPosts = $('<div>').attr('id','spinner-load-posts');

            // Events Listeners
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);
            this.on('getdata', this.getFirstData);

            $( window ).off("scroll");
            $( window ).on("scroll", this.onLoadMore);

        },

        /*
        * Render View Element
        */
        render: function(){

            // initialize reference
            this.$postsWrap = this.$('#user-program-list');
            this.$noResults = this.$('.no-results-filter');
        },

        /**
        * get reset data
        * @param dataFilter Object
        * @param replace Boolean
        */
        getFirstData: function  (dataFilter, replace) {

            dataFilter || (dataFilter = {});
            replace || (replace = false);

            if(replace) {
                this.parameters.dataFilter = dataFilter;
            }else{
                _.extend( this.parameters.dataFilter, dataFilter );
            }

            this.collection.getFirstPage( {reset:true, data:_.clone(this.parameters.dataFilter)} );
        },

        /**
        * Render view comment by model
        * @param Object marketPlaceModel Model instance
        */
        addOne: function (programUser) {

           var view = new app.UserProgramItemView({
                model: programUser,
                attributes: this.dataFilter,
                parameters: {
                    'content-review': this.$('#content-review-program-user'),
                }
            });

            this.$postsWrap.append( view.render().el );

            // show the first program review
			if( this.collection.indexOf(programUser) === 0 ) {
				view.$('.to-open-review').trigger('click');
			}
        },

        /**
        * Render all view Marketplace of the collection
        */
        addAll: function () {

            this.$postsWrap.html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {

            if( Backbone.Collection.prototype.isPrototypeOf(target) ){
                this.$spinnerPosts.appendTo( this.$el );
                window.Misc.setSpinner( this.$spinnerPosts );
            }
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {

            if( target instanceof Backbone.Collection && !target.length ){
                this.$noResults.fadeIn('fast');
            }else {
                this.$noResults.css('display', 'none');
            }

            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false,
                'callback': (function ($elSpinner) {
                    return function () {
                        $elSpinner.remove();
                    };
                })(this.$spinnerPosts)
            });

            window.Misc.removeSpinner({'wrap': this.$postsWrap})
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
                        data: _.clone(this.parameters.dataFilter),
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
