/**
* Class EditPersonEconomicSectorList extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/
//Global App Backbone

app || (app = {});

(function ($, window, document, undefined) {

	app.EditPersonEconomicSectorList = Backbone.View.extend({

		el: '#list-economic-sector-mentor',
		events: {
			'change #codigo_sector_economico': 'onEditForm'
		},
		parameters: {
			codigo_persona: '',
			owner: ''
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {

		    _.bindAll(this, 'beforeRender', 'render', 'afterRender');

			 // Extend options parameters
			if( _.isObject(opts.parameters) ){
				_.extend(this.parameters, opts.parameters);
			}

			// Init Attributes
			this.$noResults = this.$('.no-results-filter');
			this.$fieldEditing = this.$('.select-economic-sector-mentor');
			this.$wrapperData = this.$('.list-economic-sector-mentor');

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			// Events Listener
			this.listenTo( this.collection, 'add', this.addOne );
			this.listenTo( this.collection, 'reset', this.addAll );
			this.listenTo( this.collection, 'request', this.loadSpinner );
			this.listenTo( this.collection, 'sync', this.responseServer );

			// Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );
		},

		/*
		* Render View Element
		*/
		render: function() {

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
			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
			}

			// reload plugins
			if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
				window.initComponent.chosenTrigger();

			if( typeof(window.initComponent.select2Trigger) == 'function' && _.has($.fn, 'select2') )
				window.initComponent.select2Trigger();

			if( typeof(window.initComponent.chosenTrigger) == 'function' && _.has($.fn, 'chosen') )
				window.initComponent.chosenTrigger();


		},

		/**
		* update project fields
		*/
		onEditForm: function (e) {
			e.preventDefault();

			data = {
				'codigo_sector_economico': this.$('#codigo_sector_economico').find('option:selected').val(),
				'codigo_persona': this.parameters['codigo_persona'],
				'_token': $('meta[name="csrf-token"]').attr('content')
			}
			if( _.isUndefined(this.collection.findWhere( {'codigo_sector_economico': parseInt(data['codigo_sector_economico']) } )) ){

				this.loadSpinnerAdd();
				this.collection.create(data, {patch:true, wait:true});

				return;
			}

			this.render();
		},

		/**
		* Render view theme by model
		* @param Object economicSectorModel Model instance
		*/
		addOne: function (economicSectorModel) {

			var view = new app.PersonEconomicSectorItemView( {
				model: economicSectorModel,
				parameters: { 
					codigo_persona: this.parameters['codigo_persona'],
					owner: this.parameters['owner']
				 }
			} );
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
		loadSpinner: function ( target, xhr, opts ) {

			this.$noResults.css('display', 'none');

			if( target instanceof Backbone.Collection )
				window.Misc.setSpinner( this.$wrapperData );
		},

		/**
		* Load spinner on the request
		*/
		loadSpinnerAdd: function ( target, xhr, opts ) {

			window.Misc.setSpinner( this.$wrapperData );
		},

		/**
		* response of server
		*/
		responseServer: function ( target, resp, opts ) {

			if( target instanceof Backbone.Collection && !target.length )
				this.$noResults.fadeIn('fast');

			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false
			});
		}
	});

})(jQuery, this, this.document);
