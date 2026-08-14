/**
* Class ProjectProgramListView extends of Backbone View
* @author TuProyecto || Desarrolladores: @xindykatalina, @krobing
* @link http://TuProyecto.com
*/

// Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ProjectProgramListView = Backbone.View.extend({
		el: '#project-programs',
		template: _.template( ($('#project-section-programs-tpl').html() || '') ),
		events: {
			//
		},
		parameters: {
			entityModel: null,
			dataFilter: {}
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts){

			// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) ) {
				this.parameters = $.extend({}, this.parameters, opts.parameters);
            }

			//Init Attributes

			// Events Listeners
			this.listenTo( this.collection, 'add', this.addOne );
			this.listenTo( this.collection, 'reset', this.addAll );
			this.listenTo( this.collection, 'request', this.loadSpinner);
			this.listenTo( this.collection, 'sync', this.responseServer);
			this.on('getdata', this.getFirstData);
		},

		/*
		* Render View Element
		*/
		render: function(){
			var attributes = {};

			this.$el.html( this.template(attributes) );

			// initialize reference
			this.$postsWrap = this.$('#project-program-list');
			this.$noResults = this.$('.no-results-filter');

			// fire when all already is loaded
			this.ready();

			return this;
		},

		/**
		* fire libraries js
		*/
		ready: function () {

			// reload plugin
			if( _.has($.fn, 'foundation') ) {
				$(document).foundation('tab', 'reflow');
			}

            if( typeof window.initComponent.initTabs === 'function') {
                window.initComponent.initTabs();
            }

			// this.$('.scrollspy').scrollSpy();
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
			
			this.collection.getFirstPage({ reset:true, data:_.clone(this.parameters.dataFilter) });
		},

		/**
		* Render view comment by model
		* @param Object callModel Model instance
		*/
		addOne: function (callModel) {
			
		   	var view = new app.ProjectProgramItemView({
				model: callModel,
				parameters: {
					'content-review': this.$('#content-review-program-project'),
					'owner': this.parameters.entityModel ?
								(this.parameters.entityModel.get('owner') || this.parameters.entityModel.get('creator')) : false,
					dataFilter: this.parameters.dataFilter
				}
			});

			this.$postsWrap.append( view.render().el );

			// show the first program review
			if( this.collection.indexOf(callModel) === 0 ) {
				view.$('.to-open-review').trigger('click');
			}
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

			window.Misc.setSpinner( this.$el );
		},

		/**
		* response of the server
		*/
		responseServer: function ( target, resp, opts ) {

			if( target instanceof Backbone.Collection && !target.length ){
				this.$noResults.fadeIn('fast');
				$('.get-documents-project').hide();
			}else {
				this.$noResults.css('display', 'none');
				$('.get-documents-project').show();
			}

			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false
			});
		}
   });

})(jQuery, this, this.document);
