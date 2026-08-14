/**
* Class ProjectListView extends of Backbone View
* @author TuProyecto || Desarrollador: @krobing
* @link http://tuproyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ProjectListView = Backbone.View.extend({
		el: '#project-content',
		template: _.template( ($('#project-content-tpl').html() || '') ),
		templateResultCount: _.template( ($('#browse-result-count-tpl').html() || '') ),
		events: {
			//
		},
		parameters: {
			dataFilter: {},
            type: ''
		},

		/**
		* Constructor Method
		*/
		initialize: function (opts) {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onLoadMore');

			// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) ){
                this.parameters = $.extend({},this.parameters, opts.parameters);
            }

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
            attributes.type = this.parameters['type'];

			this.$el.html( this.template(attributes) );

			// Initialize attributes
			this.$noResults = this.$('#content-project-list .no-results-filter');
			this.$wrapperData = this.$('.browse-list-projects');
			this.pageOld = this.collection.state.currentPage;
			this.$blockFiltersMenu = $('#side-menu-filter');

			// set block filter
			this.$blockFiltersMenu.each(function(index, el) {
				var blockFilterMenu = new app.FilterData({
					el: el,
					collection: _this.collection,
					parameters: {
						'nameForm': '#form-filters-project',
						'callBackFilter': function (newDataFilter) {

							var routePath = {
								'principal'		: 'proyecto.index',
								'empresas'		: 'proyecto.tipo',
								'proyectos'		: 'proyecto.tipo',
								'micontenido'	: 'proyecto.tipo'
							};

							var parameters = newDataFilter;
							if(_this.parameters.type && _this.parameters.type !== 'principal') _.extend( parameters, {type:_this.parameters.type} );

							// navigate to route
							app.AppRouter.navigate( Route.route(routePath[_this.parameters.type], parameters), {trigger: false, replace: true} );

							// filter new data
							_this.trigger('getdata', _.extend({
								type: _this.parameters.dataFilter['type'],
								v: _this.parameters.dataFilter['v']
							}, newDataFilter), true);

						},
						'dataFilter': _.extend({}, _.omit(_this.parameters.dataFilter, 'type') )
					}
				});
			});

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
		* fires libraries js and functions
		*/
		ready: function () {

			// reload plugins
			if( _.has($.fn,'foundation') ) {
				$(document).foundation('tab', 'reflow');
			}

			// trigger functions
			if( typeof window.initComponent.initTabs == 'function' )
				window.initComponent.initTabs();

			if( typeof window.initComponent.configEllipsis == 'function' )
				window.initComponent.configEllipsis();
		},

		/**
		* get reset data
		*/
		getFirstData: function (dataFilter, replace) {

			dataFilter || (dataFilter = {});
            dataFilter.type = this.parameters['type'];

			replace || (replace = false);

			if(replace) {
				this.parameters.dataFilter = dataFilter;
			}else{
				_.extend( this.parameters.dataFilter, dataFilter );
			}

			this.collection.getFirstPage( {reset:true, data:_.clone(this.parameters.dataFilter)} );
			this.pageOld = this.collection.state.currentPage;

			$(window).scrollTop(0);
		},

		/**
		* Render view event by model
		* @param Object projectModel Model instance
		*/
		addOne: function (projectModel) {
			var nameViewClass = 'ProjectItemView';

			if( this.parameters.dataFilter.v !== undefined ){
				if( this.parameters.dataFilter.v == 'list'){
					nameViewClass = 'ProjectItemRosterView';
				}
			}

			var view = new app[nameViewClass]({
				model: projectModel,
				parameters: { dataFilter: this.parameters.dataFilter }
			});

			this.$wrapperData.append( view.render().el );

			if( (this.collection.indexOf(projectModel) + 1) >= this.collection.length ) {
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

			this.$noResults.css('display', 'none');

			if( this.collection.state.currentPage === this.collection.state.firstPage ) {
				window.Misc.setSpinner( this.$wrapperData.parent() );
				return;
			}else if( target instanceof Backbone.Collection ){
				this.$spinnerProduct.appendTo( this.$wrapperData.parent() );
			}else{
				this.$spinnerProduct.prependTo( this.$wrapperData.parent() );
			}

			window.Misc.setSpinner( this.$spinnerProduct );
		},

		/**
		* response of the server
		*/
		responseServer: function ( target, resp, opts ) {

			if( !target.length && target instanceof Backbone.Collection )
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

			// set result count
			this.resultCount(this.collection.state);
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
		},

		/**
		* set result count
		* @param Object states
		*/
		resultCount: function (states) {

			if( !(this.collection instanceof Backbone.PageableCollection) )
				return;

			var fromResult = 1,
				toResult = (this.collection.state.firstPage ? this.collection.state.currentPage : this.collection.state.currentPage + 1) * this.collection.state.pageSize;

			this.$('.wrap-result-count').html(this.templateResultCount({
				'from': fromResult,
				'to': toResult > this.collection.state.totalRecords ? this.collection.state.totalRecords : toResult,
				'totalRecords': this.collection.state.totalRecords
			}));
		},
	});

})(jQuery, this, this.document);
