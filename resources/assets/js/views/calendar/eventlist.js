/**
* Class EventListView extends of Backbone View
* @author TuProyecto || Desarrollador: @krobing
* @link http://tuproyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EventListView = Backbone.View.extend({
        el: '#calendar-content',
        template: _.template( ($('#calendar-events-tpl').html() || '') ),
        templateEvents: _.template( ($('#events-wall-browse-tpl').html() || '') ),
        templateDateEvents: _.template( ($('#date-events-content-tpl').html() || '') ),
        events: {
            'change #form-events-filter': 'onFilterEvents'
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

            var attributes = {};
            // console.log('Attributes', attributes);s
            this.$el.html( this.template(attributes) );

            // Reset filters
            this.dataFilter = {};

            // Initialize attributes
            this.$noResults = $('.no-results-filter');
            this.$formFilters = this.$('#form-events-filter');
            this.$eventsBrowse = this.$('#events-wall-browse');
            this.$spinnerEvents = $('<div>').attr('id','spinner-load-posts');

            // hide no results message
            if( this.collection.length ){
                this.$noResults.css('display', 'none');
            }
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

            if(_.isEmpty(dataFilter['categories']) && !_.isEmpty(this.dataFilter.categories)){
                this.dataFilter = _.omit(this.dataFilter, 'categories');
            }
            _.extend(this.dataFilter, dataFilter);

            this.collection.getFirstPage( {reset: true, data: this.dataFilter} );
            this.pageOld = this.collection.state.currentPage;
        },

        /**
        * Render view event by model
        * @param Object eventModel Model instance
        */
        addOne: function (eventModel) {
            var _this = this,
                view = new app.EventItemView({model: eventModel}),
                date = eventModel.get('fecha_evento');

            this.$eventsBrowse.append( this.templateEvents({id: date}) );
            this.$('#date-events-'+date).html( this.templateDateEvents({date: date}) );
            this.$('#calendar-events-list-'+date).append( view.render().el );

            if( typeof window.initComponent.configEllipsis == 'function' ) {
                window.initComponent.configEllipsis();
            }
        },

        /**
        * Render all event view of the collection
        */
        addAll: function () {
            if(!this.collection.length){
                this.$noResults.show();
            }

            this.$eventsBrowse.html('');
            this.collection.forEach(this.addOne, this);
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target, xhr, opts ) {

            this.$noResults.css('display', 'none');

            if( target instanceof Backbone.Collection ){
                this.$spinnerEvents.appendTo( this.$('#events-wall-browse') );
            }else{
                this.$spinnerEvents.prependTo( this.$('#events-wall-browse') );
            }

            window.Misc.setSpinner( this.$spinnerEvents );
        },

        /**
        * response of the server
        */
        responseServer: function ( target, resp, opts ) {

            if( !target.length ){
                this.$noResults.fadeIn('fast');
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
            // trigger functions
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' ){
                window.initComponent.chosenTrigger();
            }

            if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' ){
                window.initComponent.select2Trigger();
            }

            if( typeof window.initComponent.initConfigForm == 'function' ){
                window.initComponent.initConfigForm();
            }
        },

        /**
        * on filter events
        */
        onFilterEvents: function (e) {
            e.preventDefault();

            this.$eventsBrowse.html('');
            var dataFilter = window.Misc.formToJson( this.$formFilters );

            this.getFirstData(dataFilter);
        },

        /**
        * load more events
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
