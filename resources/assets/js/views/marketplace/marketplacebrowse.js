/**
* Class MarketplaceBrowseListView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MarketplaceBrowseListView = Backbone.View.extend({

		el: '#catalogo-marketplace',
		template: _.template( ($('#browse-product-tpl').html() || '') ),
		templateResultCount: _.template( ($('#browse-result-count-tpl').html() || '') ),
		events: {
			'change #marketplace-ordering': 'onOrdering'
		},
		parameters: {
			tab: 'browse',
			dataFilter: {v:'list'}
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {
			// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) ){
                this.parameters = $.extend({}, this.parameters, opts.parameters);
            }

			//Init Attributes
			this.$blockFiltersMenu = $('#side-menu-filter');
			this.pageOld = this.collection.state.currentPage;

			var _this = this;
			// set block filter
			this.$blockFiltersMenu.each(function(index, el) {
				var blockFilterMenu = new app.FilterData({
					el: el,
					collection: _this.collection,
					parameters: {
						'nameForm': '#form-filters-marketplace',
						'callBackFilter': function (newDataFilter) {

							var routePath = {
								'browse': 'marketplace.index',
								'myProducts': 'marketplace.tab',
								'myFavorites': 'marketplace.tab'
							}, routeTab = {
								'myProducts': 'misproductos',
								'myFavorites': 'favoritos'
							};

                            _this.parameters.dataFilter['orderBy'] && (newDataFilter['orderBy'] = _this.parameters.dataFilter['orderBy']);

							var parameters = newDataFilter;
							if(routeTab[_this.parameters.tab]){
                                _.extend( parameters, {tab:routeTab[_this.parameters.tab]} );
                            }

							// navigate to route
							app.AppRouter.navigate( Route.route(routePath[_this.parameters.tab], _.omit(parameters, function(value, key, object) {
                                return _.isEmpty(value);
                            })), {trigger: false, replace: true} );

							// filter new data
							_this.trigger('getdata', _.extend({
								type: _this.parameters.dataFilter['type'],
								v: _this.parameters.dataFilter['v']
							}, newDataFilter), true);
						},
						'dataFilter': _.extend({}, delete _.clone(_this.parameters.dataFilter).type )
					}
				});
			});

			// Events Listeners
			this.listenTo( this.collection, 'reset', this.render );
			this.listenTo( this.collection, 'add', this.addOne );
			this.listenTo( this.collection, 'reset', this.addAll );
			this.listenTo( this.collection, 'request', this.loadSpinner);
			this.listenTo( this.collection, 'sync', this.responseServer);
			this.on('getdata', this.getData);
		},

		/*
		* Render View Element
		*/
		render: function() {

			var attributes = {},
				_this = this;

			attributes.tab = this.parameters.tab;
			attributes['dataFilter'] = this.parameters.dataFilter;

			this.$el.html( this.template(attributes) );

			// initialize reference to elements
			this.$postsWrap = this.$('#marketplace-product-list');
			this.$noResults = this.$('.no-results-filter');
			this.$wrapPagination = this.$('.wrap-pagination');

            var queryParams =  _.omit(this.parameters.dataFilter, function(value, key, object) {
                return _.isEmpty(value) || _.contains(['type', 'v', 'tab'], key);
            });

			// set paginations
			this.$wrapPagination.each(function(index, el) {
				var pagination = new app.Paginator({
					className: 'right pagination tablet-text-right',
					collection: this.collection,
					parameters: {
						'nameForm': '#form-filters-marketplace',
						'data': this.parameters.dataFilter,
                        'queryParams': queryParams
					}
				});
				$(el).html( pagination.render().el );

			}.bind(this));

			// reload material select plugin
			$('select').material_select();
		},

        /**
        * get reset data
        * @param dataFilter Object
        * @param replace Boolean
        */
        getData: function  (dataFilter, replace) {
            dataFilter || (dataFilter = {});
            replace || (replace = false);

            // if data replaced to override dataFilter
            if(replace) {
                _.extend(this.parameters.dataFilter, _.omit(this.parameters.dataFilter, function (value, key, object) {
                    if( !_.findKey(dataFilter, key) ) {
                        delete object[key];
                    }
                    return !_.findKey(dataFilter, key);
                }), dataFilter);
            }else{
                _.extend(this.parameters.dataFilter, dataFilter);
            }

            var passedPage = parseInt(this.parameters.dataFilter.page),
                firstPage = this.collection.state.firstPage,
                pageSize = this.collection.state.pageSize;

            // Calculate passed page from query params
            passedPage = !_.isNaN(passedPage) ? (firstPage && passedPage) || passedPage - 1 : firstPage;

            this.collection.getPage(passedPage, {
                reset: true,
                data: _.clone(this.parameters.dataFilter)
            });
        },

		/**
		* Render view comment by model
		* @param Object marketPlaceModel Model instance
		*/
		addOne: function (marketPlaceModel) {

		   var view = new app.MarketPlaceProductItemView({
				model: marketPlaceModel,
				parameters: {
					dataFilter: this.parameters.dataFilter
				}
			});

			this.$postsWrap.append( view.render().el );

			// reload plugins
			if( typeof window.initComponent.configEllipsis == 'function' && _.has($.fn, 'dotdotdot') )
				window.initComponent.configEllipsis();
		},

		/**
		* Render all view Marketplace of the collection
		*/
		addAll: function () {
			this.$postsWrap.html('');
			this.collection.forEach( this.addOne, this );

			$(window).scrollTop(0);
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function ( target, xhr, opts ) {

			window.Misc.setSpinner( this.$el );
		},

		/**
		* response of the server
		*/
		responseServer: function ( target, resp, opts ) {

			if( target instanceof Backbone.Collection && !target.length ) {
				this.$noResults.fadeIn('fast');
			}else {
				this.$noResults.css('display', 'none');
			}

			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false
			});

			window.Misc.removeSpinner({'wrap': this.$postsWrap})

			// set result count
			this.resultCount(this.collection.state);
		},

		/**
		* set result count
		* @param Object states
		*/
		resultCount: function (states) {

			if( !(this.collection instanceof Backbone.PageableCollection) )
				return;

			var fromResult = this.collection.state.currentPage <= this.collection.state.firstPage ? 1 : (this.collection.state.currentPage * this.collection.state.pageSize) + 1,
				toResult = (this.collection.state.firstPage ? this.collection.state.currentPage : this.collection.state.currentPage + 1) * this.collection.state.pageSize;

			this.$('.wrap-result-count').html(this.templateResultCount({
				'from': fromResult,
				'to': toResult > this.collection.state.totalRecords ? this.collection.state.totalRecords : toResult,
				'totalRecords': this.collection.state.totalRecords
			}));
		},

		/**
		* change order by
		*/
		onOrdering: function (e) {
			var orderBy = $(e.target).find('option:selected').val();
			// filter new data
			this.trigger('getdata', {
				orderBy: orderBy
			});
		}
   });

})(jQuery, this, this.document);
