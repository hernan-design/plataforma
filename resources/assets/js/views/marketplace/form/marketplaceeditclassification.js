/**
* Class MarketPlaceEditClassification extends of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MarketPlaceEditClassification = Backbone.View.extend({

        tagName: 'div',
        id: 'container-form-infoclassification',
        className: 'edit-form',
        template: _.template( ($('#edit-product-infoclassification-form-tpl').html() || '') ),
		modalityTemplate: _.template( ($('#edit-product-modality-form-tpl').html() || '') ),
		quantityTemplate: _.template( ($('#edit-product-quantity-form-tpl').html() || '') ),
        events: {
			'change #codigo_clase_producto': 'onClasification',
            'submit #form-edit-infoclassification-product': 'onEditForm'
        },
        parameters: {
        	'dropdown': false
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender');

        	if( opts !== undefined && _.isObject(opts.parameters) )
        		this.parameters = $.extend({}, this.parameters, opts.parameters);

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

            // Events Listener
            this.listenTo( this.model, 'request', this.loadSpinner);
            this.listenTo( this.model, 'sync', this.responseServer );
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

			if( !_.isUndefined(this.model.id) ){
                this.optionClasification( this.model.get('codigo_clase_producto') );
            }

            return this;
        },

		/**
		* Fires before of run render function
		*/
		beforeRender: function () {
			// body...
		},

		/**
		* Fires after of run render function
		*/
		afterRender: function () {

			// reload plugins
			this.ready();
		},

		/**
		* reload plugins and trigger libraries
		*/
		ready: function () {
			// Fire plugins
			if( typeof(window.initComponent.spinnerTrigger) == 'function' && _.has($.fn, 'sspinner') ){
				window.initComponent.spinnerTrigger();
			}
			if( typeof(window.initComponent.configInputMask) == 'function' && _.has($.fn, 'inputmask') ) {
				window.initComponent.configInputMask();
			}
			if( typeof(window.initComponent.initConfigForm) == 'function' ){
				window.initComponent.initConfigForm();
			}
		},

		// Option clasification
		onClasification: function (e) {
			e.preventDefault();

			var option = $(e.target).find('option:selected').val();
			this.optionClasification(option);
		},

		optionClasification: function (param) {
			var clasification = this.$el.find('#clasifications-options');

			if(param == window._tp.classProduct['service']){
				clasification.html( this.modalityTemplate(this.model.toJSON()) );
				this.ready();
			}else{
				clasification.html( this.quantityTemplate(this.model.toJSON()) );
				this.ready();
			}

		},

		// Edit form
        onEditForm: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target );
            data.precio_producto = Globalize.numberParser()(data.precio_producto);
            this.model.save(data, {patch:true, wait:true});
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
        responseServer: function ( model, resp, opts ) {
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': true
            });

            if( this.parameters['dropdown'] !== false )
            	$(document).foundation( 'dropdown', 'close', $(this.parameters['dropdown']) );
        }
    });

})(jQuery, this, this.document);
