/**
* Class UserLikesListView extend of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.UserLikesListView = Backbone.View.extend({

		tagName: 'ul',
		className: 'list-user-likes',
		attributes: {
			'data-srcparams': ''
		},
		parameters: {
			'data-srcparams': ''
		},
		templateBtnMore: _.template( ($('#btn-view-more-tpl').html() || '') ),
		events: {
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts){
			_.bindAll(this, 'showMore');

			// Extend attributes
			if( opts.parameters !== undefined && _.isObject(opts.parameters) ){
				_.extend( this.parameters, opts.parameters );
			}else{
				_.extend( this.parameters, this.attributes );
			}

			//Init Attributes
			this.$modalBase = $('#modal-base-material');
			this.$elmSpinner = this.$el;
			this.collection = new window.app.UserLikesList();
			this.$wrapViewMore = $( this.templateBtnMore() );
			this.$spinnerUserLikes = $('<div>').attr('id','spinner-load-userlikes');

			// Events Listener
			this.listenTo( this.collection, 'add', this.addOne );
			this.listenTo( this.collection, 'reset', this.addAll );
			this.listenTo( this.collection, 'request', this.loadSpinner);
			this.listenTo( this.collection, 'sync', this.responseServer);
			this.$wrapViewMore.on( 'click', '.btn-view-more', this.showMore);
		},

		/*
		* Render View Element
		*/
		render: function(){

			this.$wrapViewMore.hide();
			this.collection.getFirstPage( {data:{'srcparams': this.parameters['data-srcparams']}, reset:true} );

			this.$modalBase.find('.content-modal').addClass('scroll-user-likes');
			// this.$modalBase.find('.content-modal').html( this.el );
			// this.$modalBase.find('.content-modal').append( this.$wrapViewMore );

			if( typeof window.initComponent.configScrollbar == 'function' )
				window.initComponent.configScrollbar();

			return this;
		},

		/**
		* Render view comment by model
		* @param Object categoryModel Model instance
		*/
		addOne: function (userLikesModel) {

			var view = new app.UserLikesView( {model: userLikesModel} );
			this.$el.append( view.render().el );
		},

		/**
		* Render all view comment of the collection
		*/
		addAll: function () {

			this.$el.html('');
			this.collection.forEach( this.addOne, this );
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function ( target, xhr, opts ) {

			if( this.collection.state.currentPage >= this.collection.state.lastPage ){
				this.$elmSpinner = this.$el;
			}else{
				this.$elmSpinner = this.$wrapViewMore;
				this.$spinnerUserLikes.appendTo( this.$elmSpinner );
			}

			window.Misc.setSpinner( this.$elmSpinner );
		},

		/**
		* response of the server
		*/
		responseServer: function ( target, resp, opts ) {

			// complete process
			window.Misc.removeSpinner({
				'wrap': this.$elmSpinner,
				'direct': false
			});

			if( this.collection.state.currentPage >= this.collection.state.lastPage ){
				this.$wrapViewMore.hide();
			}else{
				this.$wrapViewMore.show();
			}

		},

		/**
		* Show more users that likesd it
		*/
		showMore: function (e) {
			e.preventDefault();

			if( this.collection.hasNextPage() ){
				this.collection.getNextPage( {wait:true, data:{'srcparams': this.parameters['data-srcparams']}} );
			}
		}
   });

})(jQuery, this, this.document);
