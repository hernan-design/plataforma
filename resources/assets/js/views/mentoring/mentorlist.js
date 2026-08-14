/**
* Class MentorListView extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MentorListView = Backbone.View.extend({

		el: '#mentoring-mentors',
		template: _.template( ($('#mentor-list-tpl').html() || '') ),
		events: {
			'keyup #mentoring-name': 'onFilterMentorName'
		},
		parameters: {
			rol: '',
			dataFilter: {}
		},

		/**
		* Constructor Method
		*/
		initialize: function( opts ){
			_.bindAll(this, 'beforeRender', 'render', 'afterRender', 'onLoadMore');


			if( opts !== undefined && _.isObject(opts.parameters) ){
				_.extend( this.parameters, opts.parameters );
			}
			//Init Attributes
			// this.configAlert = {
			//     'wrapper': '#main-wrap',
			//     'closeTime': 6000,
			//     'speedOpen': 500,
			//     'speedClose': 500
			// };

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			// Events Listener
			this.listenTo( this.collection, 'change', this.render );
			this.listenTo( this.collection, 'add', this.addOne );
			this.listenTo( this.collection, 'reset', this.addAll );
			this.listenTo( this.collection, 'request', this.loadSpinner );
			this.listenTo( this.collection, 'sync', this.responseServer );
			this.on('getData', this.getFirstData);

			// Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );


			$( window ).on("scroll", this.onLoadMore);
		},

		/*
		* Render View Element
		*/
		render: function () {

			var _this = this,
				attributes = {};

			attributes.rol = this.parameters['rol'];
			attributes.dataFilter = this.parameters['dataFilter'];

			this.$el.html( this.template(attributes) );

			//Init Attributes
			this.$blockFilters = this.$('.block-filters-choice');
			this.$formFilters =  this.$('#form-filters-mentor');
			this.$wrapperData = this.$('#list-mentoring-mentor');
			this.$spinnerEvents = $('<div>').attr('id','spinner-load-questions');

			// set block filter
			this.$blockFilters.each(function(index, el) {
				var blockFilter = new app.FilterData({
					el: el,
					collection: _this.collection,
					parameters: {
						'nameForm': '#form-filters-mentor',
						'callBackFilter': function (newDataFilter) {
							app.AppRouter.navigate( Route.route('mentoria.mentores.index', newDataFilter), {trigger: false, replace: true} );
							_this.trigger('getData', newDataFilter, true);
						},
						'dataFilter': _.extend({
							// 'rol':_this.parameters.rol
						}, _this.parameters.dataFilter)
					}
				});
			});

			return this;
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function () {
			//
		},

		/**
		* Fires before of run render function
		*/
		afterRender: function () {

			this.ready();
		},

		/**
		* fires libraries js
		*/
		ready: function () {
			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
			}

			// reload plugins
			if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
				window.initComponent.chosenTrigger();

			if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
				window.initComponent.select2Trigger();

			if( typeof window.initComponent.initConfigForm == 'function' )
				window.initComponent.initConfigForm();

		},

		/**
		* get firsts data
		* @param Object dataFilter
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
		* Render view theme by model
		* @param Object personModel Model instance
		*/
		addOne: function (personModel) {

			var nameViewClass = 'MentorItemView';

			var view = new app[nameViewClass]({
				model: personModel,
				parameters: {
					rol: this.parameters['rol']
				}
			});
			this.$wrapperData.append( view.render().el );
		},

		/**
		* Render all view theme of the collection
		*/
		addAll: function () {

			this.$wrapperData.html('');
			this.collection.forEach( this.addOne, this );
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function (target, xhr, opts) {

			if( target instanceof Backbone.Collection ) {
				this.$spinnerEvents.appendTo( this.$('.content-data-list') );
			}else{
				this.$spinnerEvents.prependTo( this.$('.content-data-list') );
			}
			window.Misc.setSpinner( this.$spinnerEvents );
		},

		/**
		* response of the server
		*/
		responseServer: function ( target, resp, opts ) {

			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false
			});
		},

		onFilterMentorName: function (e) {
			e.preventDefault();
	
			var dataFilter = window.Misc.formToJson(this.$('#form-filters-mentor'));
			//dataFilter.user = this.parameters['user'];
		
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
