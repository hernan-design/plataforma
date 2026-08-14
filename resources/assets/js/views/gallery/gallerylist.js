/**
* Class GalleryListView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.GalleryListView = Backbone.View.extend({
		el: '#product-gallery-edit',
		events: {
		},
		parameters: {
			viewItemImage: 'GalleryEditItemView',
			codigo_involved: null,
			thumbs: 9,
			dataFilter: {}
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts){

			// Extend options parameters
			if( opts !== undefined && _.isObject(opts.parameters) ){
				this.parameters = $.extend({},this.parameters, opts.parameters);
			}

			//Init Attributes

			// Events Listener
			this.listenTo( this.collection, 'add', this.addOne );
			this.listenTo( this.collection, 'reset', this.addAll );
			this.listenTo( this.collection, 'request', this.loadSpinner);
			this.listenTo( this.collection, 'sync', this.responseServer);
			this.listenTo( this.collection, 'all', this.render);
			this.listenTo( this.collection, 'change', this.changeGallery);

			this.on('getdata', this.getFirstData);
		},

		/*
		* Render View Element
		*/
		render: function(){
			//
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

			this.collection.fetch({ reset:true, data:_.clone(this.parameters.dataFilter) });
		},

		/**
		* Render view comment by model
		* @param Object discussionModel Model instance
		*/
		addOne: function (galleryImageModel) {

			var _this = this;

			var view = new app[ this.parameters.viewItemImage ]({
				model: galleryImageModel,
				parameters: {
					cod_involved: this.parameters.codigo_involved
				}
			});

			// if element content is a carrousel to do another thing
			if( this.$el.hasClass('slick-initialized') ) {

				this.$el.slick('slickAdd', view.render().el );

				// refresh form slick
				window.setTimeout(function () {
					_this.$el.slick('setPosition');
				}, 100);

			}else {
				this.$el.append( view.render().el );
			}

			if( typeof(window.initComponent.initLightBox) == 'function' && _.has($.fn, 'imageLightbox') )
				window.initComponent.initLightBox();
		},

		/**
		* Render all view comment of the collection
		*/
		addAll: function () {
			
			while( this.collection.length < parseInt(this.parameters.thumbs) ){
				this.collection.push( new app.AttachmentModel(), {silent:true} );
			}

			if( this.$el.hasClass('slick-initialized') ) {
				this.$el.find('.slick-track').html('');
			}else {
				this.$el.html('');
			}

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

			// complete process
			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false
			});
		},

		/**
		* change gallery
		*/
		changeGallery: function () {

			var _this = this;

			if( this.$el.hasClass('slick-initialized') ) {

				window.setTimeout(function () {
					_this.$el.slick('setPosition');
				}, 100);
			}
		}
   });

})(jQuery, this, this.document);
