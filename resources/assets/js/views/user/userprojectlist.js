/**
* Class UserProjectListView extends of Backbone View
* @author TuProyecto || Desarrollador: @krobing
* @link http://tuproyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.UserProjectListView = Backbone.View.extend({
        el: '#user-projects',
        events: {
            // 'change .choice-filter-events': 'onFilter'
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onLoadMore');

            // Initialize attributes
            this.dataFilter = {};
            this.configAlert = {
                'wrapper': this.$el,
                'closeTime': 7000,
                'speedOpen': 500,
                'speedClose': 500
            };

            var _this = this;

            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Events Listener
            this.listenTo(this.collection, 'add', this.addOne);
            this.listenTo(this.collection, 'reset', this.addAll);
            this.listenTo(this.collection, 'request', this.loadSpinner);
            this.listenTo(this.collection, 'sync', this.responseServer);
            this.on( 'getData', this.getFirstData );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );

            $( window ).on("scroll", this.onLoadMore);
        },

        /**
        * Render View Element
        */
        render: function () {

            var attributes = {},
                _this = this;

            if( _.isObject(this.attributes) && this.attributes.viewShow !== undefined ){
                attributes.viewShow = this.attributes.viewShow;
            }

            // Reset filters
            this.dataFilter = {};

            // Initialize attributes
            this.$noResults = this.$('.no-results-filter');
            this.$wrapperData = this.$('.browse-list-projects');
            // this.$formFilters = this.$('#form-events-filter');
            this.$spinnerEvents = $('<div>').attr('id','spinner-load-posts');
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function() {
        },

        /**
        * Fires after of run render function
        */
        afterRender: function() {
            this.ready();
        },

        /**
        * get reset data
        */
        getFirstData: function (dataFilter) {

            _.extend(this.dataFilter, dataFilter);

            this.collection.getFirstPage( {reset:true, data:this.dataFilter} );
            this.pageOld = this.collection.state.currentPage;
        },

        /**
        * Render view event by model
        * @param Object projectModel Model instance
        */
        addOne: function (projectModel) {
            var view = new app.ProjectItemView({
                model: projectModel
            });
            this.$wrapperData.append( view.render().el );

            if( this.collection.indexOf(projectModel) >= (this.collection.length - 1)) {

                if( typeof window.initComponent.configEllipsis == 'function' ) {
                    window.initComponent.configEllipsis();
                }
            }
        },

        /**
        * Render all event view of the collection
        */
        addAll: function () {
            this.$wrapperData.html('');
            this.collection.forEach(this.addOne, this);
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {
            if( target instanceof Backbone.Collection ){
                this.$spinnerEvents.appendTo( this.$('.content-project-list') );
            }else{
                this.$spinnerEvents.prependTo( this.$('.content-project-list') );
            }
            window.Misc.setSpinner( this.$spinnerEvents );
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
                })(this.$spinnerEvents)
            });
        },

        /**
        * fires libraries js and functions
        */
        ready: function () {
            // trigger libraries
            // if( _.has($.fn, 'foundation') ){
            // }

            // trigger functions
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();
        },

        /**
        * on filter events
        */
        onFilter: function (e) {
            e.preventDefault();

            var dataFilter = window.Misc.formToJson(this.$formFilters);

            this.getFirstData(dataFilter);
        },

        /**
        * load more
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
