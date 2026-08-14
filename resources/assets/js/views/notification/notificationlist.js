/**
* Class NotificationListView extends of Backbone View
* @author TuProyecto || Desarrollador: @xindykatalina
* @link http://tuproyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.NotificationListView = Backbone.View.extend({
        el: '#notification-content',
        template: _.template( ($('#notification-list-tpl').html() || '') ),
        events: {
            //
        },
        parameters: {
            dataFilter: {},
            renderTemplate: 'template'
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onLoadMore');

            // extends parameters
            if( opts !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({},this.parameters, opts.parameters);

            // Initialize attributes
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

             //Init Attributes
            this.$spinnerProduct = $('<div>').attr('id','spinner-load-posts');

            // Events Listener
            this.listenTo(this.collection, 'add', this.addOne);
            this.listenTo(this.collection, 'reset', this.addAll);
            this.listenTo(this.collection, 'request', this.loadSpinner);
            this.listenTo(this.collection, 'sync', this.responseServer);
            // custome events
            this.on( 'getdata', this.getFirstData );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );

            $( window ).off("scroll");
            $( window ).on("scroll", this.onLoadMore);

        },

        /**
        * Render View Element
        */
        render: function () {

            var attributes = {},
                _this = this;

            attributes.dataFilter = this.parameters['dataFilter'];
            this.$el.html( this.template(attributes) );

            // Initialize attributes
            this.$noResults = this.$('#content-notification-list .no-results-filter');
            this.$wrapperData = this.$('.browse-list-notification');

            this.pageOld = this.collection.state.currentPage;
            this.$blockFiltersMenu = $('.wrapper-side-nav');

            // set block filter
            this.$blockFiltersMenu.each(function(index, el) {
                var blockFilterMenu = new app.FilterData({
                    el: el,
                    collection: _this.collection,
                    parameters: {
                        'nameForm': '#form-filters-project',
                        'callBackFilter': function (newDataFilter) {
                            app.AppRouter.navigate( Route.route('notificaciones.index', newDataFilter), {trigger: true, replace: true} );
                            // _this.trigger('getdata', newDataFilter, true);
                        },
                        'dataFilter': _.extend({

                        }, _this.parameters.dataFilter)
                    }
                });
            });

            // hide no results message
            if( this.collection.length )
                this.$noResults.css('display', 'none');
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function() {
            //
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
        getFirstData: function (dataFilter, replace) {

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
        * Render view event by model
        * @param Object notificationModel Model instance
        */
        addOne: function (notificationModel) {

        	var renderTemplate = this.parameters.renderTemplate;

			switch( notificationModel.get('type') ) {
				case window._tp.typeNotify['like']: renderTemplate = 'templateLike'; break;
				case window._tp.typeNotify['favorite']: renderTemplate = 'templateFavorite'; break;
			}

            var view = new app.GeneralNotifyView({
                model: notificationModel,
                parameters: {
                	dataFilter: this.parameters.dataFilter,
                	renderTemplate: renderTemplate
                }
            });
            this.$wrapperData.append( view.render().el );

            if(this.collection.indexOf(notificationModel) >= (this.collection.length-1) ) {
                this.ready();
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

        	// hide no results message
            if( this.collection.length )
                this.$noResults.css('display', 'none');

            if( target instanceof Backbone.Collection ){
                this.$spinnerProduct.appendTo( this.$wrapperData.parent() );
        		window.Misc.setSpinner( this.$spinnerProduct );
            }else{
                this.$spinnerProduct.prependTo( this.$wrapperData.parent() );
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
                })(this.$spinnerProduct)
            });
        },

        /**
        * fires libraries js and functions
        */
        ready: function () {

            // trigger functions
            if( typeof window.initComponent.initConfigForm == 'function' ){
                window.initComponent.initConfigForm();
            }
            if( typeof window.initComponent.configEllipsis === 'function' && _.has($.fn, 'dotdotdot') ) {
                window.initComponent.configEllipsis();
            }
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

