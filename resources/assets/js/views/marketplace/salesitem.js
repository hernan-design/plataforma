/**
* Class SalesItemView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.SalesItemView = Backbone.View.extend({

        tagName: 'li',
        template: _.template( ($('#my-sales-item-list-tpl').html() || '') ),
        events: {
            //
        },

        /**
        * Constructor Method
        */
        initialize: function() {

            //Init Attributes

            // Events Listener
            this.listenTo( this.model, "change:codigo_compra", this.render );
            this.listenTo( this.model, 'change:state_purchase', this.statePurchase );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            // Instance of Buttons Actions Purchase
            this.buttonsActions = this.$('.buttons-sale-action');

            this.buttonsActions.each(function(index, element) {

	            var buttonsMarketPlace = new app.MarketPlaceSaleActionsView({
	                el: element,
	                model: this.model,
	                parameters: {
	                    tab: 'ventas',
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
        	if( this.model.get('state_purchase') == 'rejected' ) {
        		this.remove();
        	}

        	// reload element when the purchase state change to confirm or pending
        	if( _.contains(['confirm','pending'], this.model.changed['state_purchase']) ) {
        		this.render();
        	}
        },

    	/**
		* remove element
    	*/
    	remove: function () {

    		var _this = this;

    		this.$el.fadeOut('fast', function() {
    			_this.$el.remove();
    			_this.stopListening();

    			// remove model into collection
    			// _this.model.collection.remove(_this.model, {silent:true});
    		});

    		return this;
    	}
    });

})(jQuery, this, this.document);
