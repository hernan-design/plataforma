/**
* Class MarketPlacePromotionsItemView extends of Backbone View
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MarketPlacePromotionsItemView = Backbone.View.extend({

		tagName: 'li',
		template: _.template( ($('#promotions-product-item-list-tpl').html() || '') ),
		events: {

		},

		/**
		* Constructor Method
		*/
		initialize: function(){

			//Init Attributes

			// Events Listener
			this.listenTo( this.model, "change", this.render );
		},

		/*
		* Render View Element
		*/
		render: function(){

			var attributes = this.model.toJSON();
	
			this.$el.html( this.template(attributes) );

			// reload plugins
			if( typeof window.initComponent.configEllipsis == 'function' && _.has($.fn, 'dotdotdot') )
				window.initComponent.configEllipsis();

			return this;
		}
	});

})(jQuery, this, this.document);
