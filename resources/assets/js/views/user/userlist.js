/**
* Class UserListView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserListView = Backbone.View.extend({

        el: '#user-content',
        template: _.template( ($('#filters-friends-tpl').html() || '') ),
        events: {
            //
        },
        parameters: {
           dataFilter: {}
        },
        pageOld: 1,

        /**
        * Constructor Method
        */
        initialize : function(opts){
            _.bindAll(this, 'onLoadMore');

            // Extend options parameters
            if( _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            //Init Attributes

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

            var attributes = {},
                _this = this;

            attributes.dataFilter = this.parameters['dataFilter'];

            this.$el.html( this.template(attributes) );

            // initialize reference
            this.$postsWrap = this.$('#friends-wrap');

            this.$noResults = this.$('.no-results-filter');
            this.$blockFilters = this.$('.block-filters-choice');
            this.$spinnerPosts = $('<div>').attr('id','spinner-load-posts');

            // set block filter
            this.$blockFilters.each(function(index, el) {
                var blockFilter = new app.FilterData({
                    el: el,
                    collection: _this.collection,
                    parameters: {
                        'nameForm': '#form-conctacts-filter',
                        'callBackFilter': function (newDataFilter) {

                            app.AppRouter.navigate( Route.route('usuario.index', newDataFilter), {trigger: false, replace: true} );
                            _this.trigger('getdata', newDataFilter, true);
                        },
                        'dataFilter': _.extend({

                        }, _this.parameters.dataFilter)
                    }
                });
            });

            // Trigger plugins
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
                window.initComponent.select2Trigger();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

            if( this.collection.length )
                this.$noResults.css('display', 'none');
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
            this.pageOld = this.collection.state.currentPage;
        },

        /**
        * Render view comment by model
        * @param Object userModel Model instance
        */
        addOne: function (userModel) {

            var view = new app.UserItemView({
                model: userModel
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
