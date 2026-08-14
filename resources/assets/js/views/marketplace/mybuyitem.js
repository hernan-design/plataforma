/**
* Class MyBuyItemView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MyBuyItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#my-buy-item-list-tpl').html() || '') ),
        events: {
            //
        },

        /**
        * Constructor Method
        */
        initialize: function(){

            //Init Attributes

            // Events Listener
            this.listenTo( this.model, "change:codigo_compra", this.render );
            this.listenTo( this.model, 'change:state_purchase', this.statePurchase );
        },

        /*
        * Render View Element
        */
        render: function(){

            var attributes = this.model.toJSON();
            console.log(attributes);
            this.$el.html( this.template(attributes) );

            // Instance of Buttons Actions Purchase
            this.buttonsActions = this.$('.buttons-purchase-action');

            this.buttonsActions.each(function(index, element) {

	            var buttonsMarketPlace = new app.MarketPlacePurchaseActionsView({
	                el: element,
	                model: this.model,
	                parameters: {
	                    tab: 'compras',
	                    index: index
	                }
	            });

            }.bind(this));

            return this;
        },

        /**
		* when changed the purchase state
        */
        statePurchase: function (model, value) {

        	// remove element when cancel offer
        	if( this.model.get('state_purchase') == 'rejected' || this.model.get('state_purchase') == 'removed' ) {
        		this.remove();
        	}

        	// reload element when the purchase state change to confirm
        	if( this.model.changed['state_purchase'] === 'confirm' ) {
        		this.render();
        	}
        }
    });

})(jQuery, this, this.document);
