/**
* Class MarketPlaceProductItemView extends of Backbone View
* @author TuProyecto || Desarrolladores : @xindykatalina, @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MarketPlaceProductItemView = Backbone.View.extend({

		tagName: 'li',
		template: _.template( ($('#product-item-list-tpl').html() || '') ),
		templateViewList: _.template( ($('#product-roster-list-tpl').html() || '') ),
		events: {
			//
		},
		parameters: {
			dataFilter: {}
		},

		/**
		* Constructor Method
		*/
		initialize: function(opts){
			// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) )
				this.parameters = $.extend({}, this.parameters, opts.parameters);

			//Init Attributes
			this.favoriteModel = new app.FavoriteModel();

			// Events Listener
			this.listenTo( this.model, "change", this.render );
		},

		/*
		* Render View Element
		*/
		render: function(){

			var attributes = this.model.toJSON();
			
			this.$el.html(
				this.parameters.dataFilter.v == 'list' ? this.templateViewList(attributes)
					: this.template(attributes)
			);

			this.buttonsActions = this.$('#buttons-marketplace-product-action');

			this.buttonsMarketPlace = new app.MarketPlaceProductActionsView({
				el: this.buttonsActions,
				model: this.model,
				parameters: {
					'type_action': 'state'
				}
			});

			// instance favorite
			this.favoriteView = new app.FavoriteView({
				el: this.$('.post-favorite-icon.TPfavoritelink'),
				model: this.favoriteModel,
				parameters: {
					codFavorite: this.model.get('codigo_favorito'),
					favoriteState: this.model.get('favorito_auth'),
					srcparams: this.model.get('srcparams')
				}
			});

			return this;
		}
	});

})(jQuery, this, this.document);
