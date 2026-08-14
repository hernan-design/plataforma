/**
* Class MarketPlacePurchaseEvaluationView extends of Backbone View
* @author TuProyecto || Desarrolladores : @xindykatalina, @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MarketPlacePurchaseEvaluationView = Backbone.View.extend({

		el: '#marketplace-content',
		template: _.template( ($('#marketplace-purchase-evaluation-tpl').html() || '') ),
		events: {
			'submit #form-create-eval-purchase': 'onStore'
		},
		parameters: {
		   tab: ''
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {
			_.bindAll(this, 'onReadyFile');

			//Init parameters
			if(!_.isUndefined(opts) && _.isObject(opts.parameters))
				this.parameters = $.extend({},this.parameters, opts.parameters);

			//Init parameters
			this.configAlert = {
				'wrapper': '#main-wrap',
				'closeTime': 6000,
				'speedOpen': 500,
				'speedClose': 500
			};

			this.evaluationPurchaseModel = new app.EvaluationPurchaseModel();
			this.$buttonRegistration = this.$('.register-calification');

			// Events Listener
			this.listenTo( this.model, 'change', this.render );
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );

			this.listenTo( this.evaluationPurchaseModel, 'request', this.loadSpinner );
			this.listenTo( this.evaluationPurchaseModel, 'sync', this.responseServerRegistration );
		},

		/*
		* Render View Element
		*/
		render: function() {



			var attributes = this.model.toJSON(),
                searchNull = _.findWhere(this.model.get('acuerdos_adjuntos'), {direccion_adjunto: null}),
                validationDeliverables = !_.isUndefined(searchNull) ? !_.isNull(searchNull.direccion_adjunto) : true;

            attributes.validationDeliverables = validationDeliverables;
			attributes.tab = this.parameters.tab;

			this.$el.html( this.template(attributes) );

			// fires plugins and functions
			this.ready();

               // Event listener for radio buttons (solution for mobile issue)
               const icons = document.querySelectorAll('.mdi-star');

               // Añadimos el evento a los iconos con clase `mdi-star`
               icons.forEach(function (icon) {
                   icon.addEventListener('click', handleRadioClick);
                   // Para dispositivos móviles, también puedes añadir `touchstart`
                   icon.addEventListener('touchstart', handleRadioClick);
               });

	// Función manejadora para cuando el icono es clicado
        function handleRadioClick(event) {
            event.stopPropagation();

            // Obtener el id del radio button a partir del atributo 'data-id' del icono
            const selectedIcon = event.target;
            const radioId = selectedIcon.getAttribute('data-id');  // Obtiene el valor del atributo "data-id"
            const selectedRadio = document.querySelector(`#${radioId}`); // Selecciona el radio button asociado por ID

            if (selectedRadio) {
                // Marcar el radio button seleccionado
                selectedRadio.checked = true;

                // Obtener el grupo de radios por el nombre
                const radioGroupName = selectedRadio.getAttribute('name');
                const radioGroup = document.querySelectorAll(`input[name="${radioGroupName}"]`);

                // Recorre el grupo de radio buttons y desmarca los que no han sido seleccionados
                radioGroup.forEach(function (radio) {
                    if (radio !== selectedRadio) {
                        radio.checked = false;
                    }
                });

            }
        }

			return this;
		},

         /**
        * Handle radio button change event
        */
		onRadioChange: function(event) {
			event.stopPropagation();

			const selectedRadio = event.target;
			const radioGroupName = selectedRadio.getAttribute('name');
			const radioGroup = document.querySelectorAll(`input[name="${radioGroupName}"]`);

			radioGroup.forEach(function (radio) {
				if (radio !== selectedRadio) {
					radio.checked = false;  // Ensure other radios are deselected
				}
			});

			// Log selection to verify behavior
			console.log(`Radio button selected: ${selectedRadio.value}`);
		},

		/**
		* fires libraries js
		*/
		ready: function () {

			// fires fuctions plugin
			if( _.has($.fn, 'foundation') ) {
				$(document).foundation('abide', 'reflow');
				$(document).foundation('dropdown', 'reflow');
				$(document).foundation('tooltip', 'reflow');
			}

			// reload plugins
			if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
				window.initComponent.select2Trigger();

			if( _.has($.fn, 'dotdotdot') && typeof window.initComponent.configEllipsis == 'function' )
				window.initComponent.configEllipsis();

			if( typeof window.initComponent.initConfigForm == 'function' )
				window.initComponent.initConfigForm();
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function () {
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


		},

		/**
		* Event Items Evaluation Purchase
		*/
		onStore: function (e) {
			e.preventDefault();

			var data = window.Misc.formToJson( e.target );
            data.codigo_compra = this.model.get('codigo_compra');
			data.referee = this.parameters.tab;

			this.evaluationPurchaseModel.save( data, {patch: true, wait:true} );
		},

		/**
		* response of the server model evaluation purchase
		*/
		responseServerRegistration: function ( model, resp, opts ) {
			// response success or error
			var type = resp.success ? 'success' : 'alert',
				text = resp.success ?
					(resp.message !== undefined ? resp.message : '...')
					: resp.errors;

			if( _.isObject( resp.errors ) ){

				var listError = '<ul>';

				$.each(resp.errors, function(field, item) {
					 listError += '<li>'+ item[0] +'</li>';
				});
				listError += '</ul>';

				text = listError;
			}

			var config = {
				'text': text,
				'type': type
			};
			_.extend( this.configAlert, config );

			//complete proccess
			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false,
				'callback': (function (conf, re, _this) {
					return function () {
						_this.$buttonRegistration.removeClass('disabled');
						if(!_.isUndefined(re.success)) {
							if( re.success ){
								// Redirect to Content
								Backbone.history.navigate(_this.model.get('seller') ? Route.route('marketplace.ventas.index') : Route.route('marketplace.compras.index'), { trigger:true })
							}
							window.Misc.showAlertBox( conf );
						}
					}
				})(this.configAlert, resp, this)
			});
		},

        /**
        * when the file is put over loader
        * @param Number id
        * @param String name
        */
        onReadyFile: function (id, name) {
        	this.ready();
        }
   });

})(jQuery, this, this.document);
