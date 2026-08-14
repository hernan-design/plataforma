/**
* Class UserNetworkListView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserNetworkListView = Backbone.View.extend({

        el: '#contacts-users-friendship',
        events: {
            'change .choice-filter-contacts': 'onFilterContacts',
            'keyup #username': 'onFilterContacts'
        },
        parameters: {
            userprofile: ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            _.bindAll(this, 'onLoadMore');

            // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            // Reset filters
            this.dataFilter = { 'userprofile': this.parameters['userprofile'] };

            //Init Attributes
            this.$postsWrap = this.$('#user-network-wrap');
            this.$formFilters = this.$('#form-conctacts-filter');
            this.$noResults = this.$('.no-results-filter');
            this.$spinnerPosts = $('<div>').attr('id','spinner-load-posts');
            
            // Events Listener
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'reset', this.addAll );
            this.listenTo( this.collection, 'request', this.loadSpinner);
            this.listenTo( this.collection, 'sync', this.responseServer);
            this.listenTo( this.collection, 'all', this.render);
            this.on('getdata', this.getFirstData);

            $( window ).on("scroll", this.onLoadMore);

            this.trigger('getdata');
        },

        /*
        * Render View Element
        */
        render: function(){

            if( this.collection.length )
                this.$noResults.css('display', 'none');
        },

        /**
        * on filter contacts
        */
        onFilterContacts: function (e) {
            e.preventDefault();

            var dataFilter = window.Misc.formToJson(this.$formFilters);
            dataFilter.user = this.parameters['user'];

            this.getFirstData(dataFilter);
        },

        /**
        * Render view comment by model
        * @param Object userNetworkModel Model instance
        */
        addOne: function (userNetworkModel) {

            var view = new app.UserNetworkItemView({
                model: userNetworkModel
            });
            this.$postsWrap.append( view.render().el );
        },

        /**
        * Render all view comment of the collection
        */
        addAll: function () {
            
            this.$postsWrap.html('');
            this.collection.forEach( this.addOne, this );
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {

            this.$noResults.css('display', 'none');

            if( Backbone.Collection.prototype.isPrototypeOf(target) ){
                this.$spinnerPosts.appendTo( this.$postsWrap );
                window.Misc.setSpinner( this.$spinnerPosts );
            }
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

            window.Misc.removeSpinner({'wrap': this.$postsWrap})
        },

        /**
        * get reset data
        *
        */
        getFirstData: function  (dataFilter) {

            _.extend(this.dataFilter, dataFilter);

            this.collection.getFirstPage( {reset:true, data:this.dataFilter} );
            this.pageOld = this.collection.state.currentPage;
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
