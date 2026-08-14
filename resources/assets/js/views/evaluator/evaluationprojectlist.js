/**
* Class EvaluationProjectListView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.EvaluationProjectListView = Backbone.View.extend({
		el: '#evaluation-inner-content',
		template: _.template( ($('#evaluation-project-list-tpl').html() || '') ),
		templateResultCount: _.template( ($('#browse-result-count-tpl').html() || '') ),
		events: {
			//
		},
		parameters: {
			dataFilter: {}
		},

		/**
		* Contructor method
		* @param opts Object
		*/
		initialize: function (opts) {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender');

			// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) )
				this.parameters = $.extend({}, this.parameters, opts.parameters);

			// Init atributtes

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			// Events listener
			this.listenTo( this.collection, 'change', this.render );
			this.listenTo( this.collection, 'add', this.addOne );
			this.listenTo( this.collection, 'reset', this.addAll );
			this.listenTo( this.collection, 'request', this.loadSpinner );
			this.listenTo( this.collection, 'sync', this.responseServer );
			this.on('getData', this.getFirstData);

			// Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );
		},

		/**
		* Render view element
		*/
		render: function () {

			var attributes = {},
				_this = this;

			attributes.dataFilter = this.parameters['dataFilter'];
			this.$el.html( this.template(attributes) );

			// Initialize attributes
			this.$noResults = this.$('#content-evaluation-projects .no-results-filter');
			this.$wrapperData = this.$('.browse-list-evaluation-project');
			this.$wrapPagination = this.$('.wrap-pagination');

			// set paginations
			this.$wrapPagination.each(function(index, el) {

				var pagination = new app.Paginator({
					className: 'right pagination tablet-text-right',
					collection: _this.collection,
					parameters: {
						'nameForm': '#form-filters-evaluation',
						'data': this.parameters.dataFilter
					}
				});
				$(el).html( pagination.render().el );

			}.bind(this));

			this.$blockFiltersMenu = this.$('#side-menu-filter');

			// set block filter
			this.$blockFiltersMenu.each(function(index, el) {
				var blockFilterMenu = new app.FilterData({
					el: el,
					collection: _this.collection,
					parameters: {
						'nameForm': '#form-filters-evaluation',
						'callBackFilter': function (newDataFilter) {
							app.AppRouter.navigate( Route.route('evaluacion.index', newDataFilter), {trigger: false, replace: true} );
							_this.trigger('getData', newDataFilter, true);

						},
						'dataFilter': _.extend({}, _this.parameters.dataFilter)
					}
				});
			});

			// hide or show message to there's not results
			if( this.collection.length )
				this.$noResults.css('display', 'none');

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
			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				$(document).foundation('abide', 'reflow');
			}

			// reload plugins
            if( typeof(window.initComponent.spinnerTrigger) == 'function' && _.has($.fn, 'spinner') )
                window.initComponent.spinnerTrigger();

            if( typeof window.initComponent.select2Trigger == 'function' && _.has($.fn, 'select2') )
                window.initComponent.select2Trigger();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

            if( typeof window.initComponent.configInputMask == 'function' && _.has($.fn, 'inputmask') )
                window.initComponent.configInputMask();
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
		},

		/**
		* Render view theme by model
		* @param Object themeModel Model instance
		*/
		addOne: function (evaluationModel) {

			var view = new app.EvaluationProjectItemView({
				model: evaluationModel,
				parameters: {
					//
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

			// hide or show message to there's not results
			if( this.$noResults && this.$noResults.length ) this.$noResults.css('display', 'none');

			window.Misc.setSpinner( this.$wrapperData );
		},

		/**
		* response of the server
		*/
		responseServer: function ( target, resp, opts ) {

			if( target instanceof Backbone.Collection && !target.length )
				this.$noResults.fadeIn('fast');

			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false
			});

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
		}
	});

})(jQuery, this, this.document);
