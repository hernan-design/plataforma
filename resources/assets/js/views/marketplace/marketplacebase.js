/**
* Class BasesMarketPlaceView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function  ($, window, document, undefined) {

	app.BaseMarketPlaceView = Backbone.View.extend({

		el: '#marketplace-content',
		template: _.template( ($('#marketplace-list-tpl').html() || '') ),
		events: {
		},
		parameters: {
			tab: 'default',
			action: '',
			dataFilter: {}
		},

		/**
		* Constructor Method
		*/
		initialize: function ( opts ) {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender');

			// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) )
				_.extend(this.parameters, opts.parameters);

			// Init Attributes
			this.buysList = new app.BuysList();
			this.salesList = new app.SalesList();
            this.promotionModel = new app.PromotionModel();
			this.promotionsList = new app.PromotionsList();
            this.marketPlaceList = new app.MarketPlaceList();
            this.marketPlaceTrendingList = new app.MarketPlaceList();
            this.marketplacePromotionsList = new app.PromotionsList();

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			// Events Listeners
			this.on('beforeRender', this.beforeRender);
			this.on('afterRender', this.afterRender);
		},

		/*
		* Render View Element
		*/
		render: function () {
			// Initialize Attributes
			var attributes = {};
			attributes.tab = this.parameters.tab;
			attributes.action = this.parameters.action;
			
			this.$el.html( this.template(attributes) );

			$( window ).off("scroll");
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function() {
			// code goes here
		},

		/**
		* Fires before of run render function
		*/
		afterRender: function() {

			this.ready();

			// get section
			this.stuffTab( this.parameters.tab, this.parameters.action );
		},

		/**
		* fires libraries js
		*/
		ready: function () {
			// trigger libraries
			if( _.has($.fn, 'foundation') ){
                $(document).foundation();
				$(document).foundation('tab', 'reflow');
                // $(document).foundation('topbar', 'reflow');
                // $(document).foundation('dropdown', 'reflow');
			}

			// reload plugins
			if( typeof window.initComponent.configScrollbar == 'function' && _.has($.fn, 'perfectScrollbar') )
				window.initComponent.configScrollbar();
		},

		/**
		* switch tabs mentoring
		*/
		stuffTab: function ( tab, action ) {
			action = (action = '');

			var _this = this,
				stuffTab = {
					'browse' : function() {
						_.each(['promotions', 'trending', 'browse'], function (value, index) {
							_this.stuffAction(value);
						});
					},

					'createSeller': function () {
						_.each(['trending','browse','createSeller'], function (value, index) {
							_this.stuffAction(value);
						});
					},

					'createProduct': function () {
						_.each(['createProduct'], function (value, index) {
							_this.stuffAction(value);
						});
					},

					'createPromotion': function () {
						_.each(['createPromotion'], function (value, index) {
							_this.stuffAction(value);
						});
					},

					'myBuys': function () {
						_.each(['myBuys'], function (value, index) {
							_this.stuffAction(value);
						});
					},

					'mySales': function () {
						_.each(['mySales'], function (value, index) {
							_this.stuffAction(value);
						});
					},

					'myProducts': function () {
						_.each(['browse'], function (value, index) {
							_this.stuffAction(value);
						});
					},

					'myFavorites': function () {
						_.each(['browse'], function (value, index) {
							_this.stuffAction(value);
						});
					},

					'myPromotions': function () {
						_.each(['myPromotions'], function (value, index) {
							_this.stuffAction(value);
						});
					},

					'default': function () {
						_.each(['promotions', 'trending', 'browse'], function (value, index) {
							_this.stuffAction(value);
						});
					}
				};

			if (stuffTab[tab]) {
				stuffTab[tab]();
			} else {
				stuffTab['default']();
			}

			// runs actions
			if( action.length ){
				 if( _.isArray(action) ) {
					_.each(action, function (value, index) {
						_this.stuffAction(value);
					});
				}else {
					this.stuffAction(action);
				}
			}
		},

		/**
		* switch actions mentoring
		*/
		stuffAction: function ( action ) {
			var _this = this,
				stuffAction = {
					'browse' : function() {
						_this.getBrowse();
					},
					'trending' : function() {
						_this.getTrending();
					},
					'promotions' : function() {
						_this.getPromotions();
					},
					'createSeller' : function() {
						_this.getCreateSeller();
					},
					'createProduct': function () {
						_this.getCreateProduct();
					},
					'createPromotion': function () {
						_this.getCreatePromotion();
					},
					'myBuys': function () {
						_this.getMyBuys();
					},
					'mySales': function () {
						_this.getMySales();
					},
					'myPromotions': function () {
						_this.getMyPromotions();
					},
					'default': function () {
						//
					}
				};

			if (stuffAction[action]) {
				stuffAction[action]();
			} else {
				stuffAction['default']();
			}
		},

		/**
		* get results of marketplace browse
		*/
		getBrowse: function () {

			if( this.marketplaceBrowseListView instanceof Backbone.View ) {
				this.marketplaceBrowseListView.stopListening();
				this.marketplaceBrowseListView.undelegateEvents();
			}

			// Intance and get Data of MarketPlace list view
			this.marketplaceBrowseListView = new app.MarketplaceBrowseListView({
				collection: this.marketPlaceList,
				parameters: {
					tab: this.parameters.tab,
					dataFilter: this.parameters.dataFilter
			   }
			});
			this.marketplaceBrowseListView.render();
			this.marketplaceBrowseListView.trigger('getdata');
		},

		/**
		* get results of marketplace trending
		*/
		getTrending: function () {

			if( this.marketplaceTrendingListView instanceof Backbone.View ) {
				this.marketplaceTrendingListView.stopListening();
				this.marketplaceTrendingListView.undelegateEvents();
			}

			this.marketplaceTrendingListView = new app.MarketplaceTrendingListView( {collection: this.marketPlaceTrendingList} );

			if( this.marketplaceTrendingListView.$el.length ) {
				this.marketplaceTrendingListView.render();
				this.marketplaceTrendingListView.trigger('getdata');
			}
		},

		/**
		* get results of marketplace promotions
		*/
		getPromotions: function () {
			if( this.marketplacePromotionsListView instanceof Backbone.View ) {
				this.marketplacePromotionsListView.stopListening();
				this.marketplacePromotionsListView.undelegateEvents();
			}

			this.marketplacePromotionsListView = new app.MarketplacePromotionsListView({
                collection: this.marketplacePromotionsList,
                parameters: {
                    dataFilter: {
                        view: true
                    }
                }
            });

			if( this.marketplacePromotionsListView.$el.length ) {
				this.marketplacePromotionsListView.render();
				this.marketplacePromotionsListView.trigger('getdata');
			}
		},

		/**
		* get marketplace create seller form
		*/
		getCreateSeller: function () {

			if( this.marketPlaceCreateSellerView instanceof Backbone.View ) {
				this.marketPlaceCreateSellerView.stopListening();
				this.marketPlaceCreateSellerView.undelegateEvents();
			}

			// Instance create seller form for marketplace
			this.marketPlaceCreateSellerView = new app.MarketPlaceCreateSellerView();
			this.marketPlaceCreateSellerView.render();
		},

		/**
		* get marketplace create product form
		*/
		getCreateProduct: function () {

			// Instance create product form for marketplace
			this.marketPlaceCreateProductView = new app.MarketPlaceCreateProductView();
			this.marketPlaceCreateProductView.render();
		},

		/**
		* get marketplace create promotion form
		*/
		getCreatePromotion: function () {
            if(!_.isUndefined(this.parameters.dataFilter['promotion'])){
                this.promotionModel.set( {'codigo_promocion': this.parameters.dataFilter['promotion']}, {silent: true} );
                this.promotionModel.fetch();
            }

			// Instance create promotion form for marketplace
			this.marketPlaceCreatePromotionView = new app.MarketPlaceCreatePromotionView({
                model: this.promotionModel
            });

            if(_.isUndefined(this.parameters.dataFilter['promotion'])){
                if(!_.isUndefined(this.promotionModel.get('codigo_promocion'))){
                    this.promotionModel.clear({silent: true}).set(this.promotionModel.defaults);
                }

			    this.marketPlaceCreatePromotionView.render();
            }
		},

		/**
		* get results of myBuys
		*/
		getMyBuys: function () {

			if( this.myBuysListView instanceof Backbone.View ) {
				this.myBuysListView.stopListening();
				this.myBuysListView.undelegateEvents();
			}

			// Intance and get Data of Buys list view
			this.myBuysListView = new app.MyBuysListView( {collection: this.buysList} );
			this.myBuysListView.render();
			this.buysList.getFirstPage( {reset: true, data: this.parameters.dataFilter } );
		},

		/**
		* get results of mySales
		*/
		getMySales: function () {

			if( this.salesListView instanceof Backbone.View ) {
				this.salesListView.stopListening();
				this.salesListView.undelegateEvents();
			}

			// Intance and get Data of Sales list view
			this.salesListView = new app.SalesListView( {collection: this.salesList} );
			this.salesListView.render();
			this.salesList.getFirstPage( {reset: true, data: this.parameters.dataFilter } );
		},

		/**
		* get results of myPromotions
		*/
		getMyPromotions: function () {

			if( this.promotionsListView instanceof Backbone.View ) {
				this.promotionsListView.stopListening();
				this.promotionsListView.undelegateEvents();
			}

			// Intance and get Data of Sales list view
			this.promotionsListView = new app.PromotionsListView( {collection: this.promotionsList} );
			this.promotionsListView.render();
			this.promotionsList.getFirstPage( {reset: true, data: this.parameters.dataFilter } );
		}

	});

})(jQuery, this, this.document);
