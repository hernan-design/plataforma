/**
* Class MarketplaceTrendingListView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MarketplaceTrendingListView = Backbone.View.extend({

		el: '#content-marketplace-trending-list',
		events: {

		},
		parameters: {
			dataFilter: { 'type': 'trending' }
		},

		/**
		* Constructor Method
		*/
		initialize: function(opts){

			// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) )
				this.parameters = $.extend({},this.parameters, opts.parameters);

			var _this = this;
			// Events Listener
			this.listenTo( this.collection, 'add', this.addOne );
			this.listenTo( this.collection, 'reset', this.addAll );
			this.listenTo( this.collection, 'request', this.loadSpinner );
			this.listenTo( this.collection, 'sync', this.responseServer );
			this.on('getdata', this.getFirstData);

			this.collection.state.pageSize = 8;
		},

		/*
		* Render View Element
		*/
		render: function () {

			var _this = this;

			//Init Attributes
			this.$noResults = this.$('.no-results-filter');
			this.$wrapperData = this.$('#marketplace-product-trending-list');

			// Fires plugins
			if( typeof window.initComponent.configSlick == 'function' && _.has($.fn, 'slick') ){
				window.initComponent.configSlick();
				this.slickTrending = this.$wrapperData.slick('getSlick');
			}

			// hide no results message
			if( this.collection.length )
				this.$noResults.css('display', 'none');

			return this;
		},

		/**
		* get reset data
		*
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
		* Render view by model
		* @param Object marketPlaceModel Model instance
		*/
		addOne: function (marketPlaceModel) {

			var _this = this;

			var view = new app.MarketPlaceTrendingItemView({
				model: marketPlaceModel,
				attributes: this.dataFilter
			});
			this.$wrapperData.slick('slickAdd', view.render().el );

			// refresh form slick
			window.setTimeout(function () {
				_this.$wrapperData.slick('setPosition');
			}, 100);

			// trigger libraries
			if( _.has($.fn, 'foundation') ) {
				$(document).foundation('tooltip', 'reflow');
			}
		},

		/**
		* Render all view theme of the collection
		*/
		addAll: function () {
			this.$wrapperData.find('.slick-track').html('');
			this.collection.forEach( this.addOne, this );
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function (target, xhr, opts) {
			window.Misc.setSpinner( this.$wrapperData );
		},

		/**
		* response of the server
		*/
		responseServer: function ( target, resp, opts ) {

			if( !target.length )
				this.$noResults.fadeIn('fast');

			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false
			});
		}
	});

})(jQuery, this, this.document);
