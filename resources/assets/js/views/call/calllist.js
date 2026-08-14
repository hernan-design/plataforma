/**
* Class CallListView of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CallListView = Backbone.View.extend({

        el: '#calls-content',
        template: _.template( ($('#list-call-tpl').html() || '') ),
        events: {
            'change #form-calls-filter': 'onChangeFilterCall'
        },
        parameters: {
            dataFilter: {},
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

            var attributes = {},
                _this = this;
            attributes.tab = "browse";
            attributes['dataFilterDisplay'] = {v: 'list'};

            this.$el.html( this.template(attributes) );

            // initialize reference
            this.$postsWrap = this.$('#browse-list-call');
            this.$noResults = this.$('.no-results-filter');
            this.$formFilterCall = this.$('#form-calls-filter');

            this.$blockFiltersMenu = $('.wrapper-side-nav');

            // set block filter
            this.$blockFiltersMenu.each(function(index, el) {
                var blockFilterMenu = new app.FilterData({
                    el: el,
                    collection: _this.collection,
                    parameters: {
                        'nameForm': '#form-filters-programs',
                        'callBackFilter': function (newDataFilter) {

                            app.AppRouter.navigate( Route.route('convocatoria.index', newDataFilter), {trigger: false, replace: true} );
                            _this.trigger('getdata', newDataFilter, true);
                        },
                        'dataFilter': _.extend({

                        }, _this.parameters.dataFilter)
                    }
                });
            });
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

        onChangeFilterCall: function(e) {
            e.preventDefault();

            var dataFilter =  window.Misc.formToJson( this.$formFilterCall );
            this.getFirstData(dataFilter, null);
        },



        /**
        * Render view comment by model
        * @param Object callModel Model instance
        */
        addOne: function (callModel) {

           var view = new app.CallItemView({
                model: callModel,
                attributes: this.dataFilter
            });

            this.$postsWrap.append( view.render().el );
        },

        /**
        * Render all view Calls of the collection
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
