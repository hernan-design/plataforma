/**
* Class ApplyEntityProgramView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ApplyEntityProgramView = Backbone.View.extend({
		el: '#apply-entity-program',
		template: _.template( ($('#entity-apply-program-tpl').html() || '') ),
		templateInvalid: _.template( ($('#invalid-message-apply-program-tpl').html() || '') ),
		events: {
			'change select#codigo_usuario': 'onChoiceEntity'
		},
		parameters: {
            step: '',
            select: '',
            programModel: null,
			url_convocatoria: '',
		},

		newEntity: null,

		/**
		* Constructor Method
		*/
		initialize: function (opts) {
			_.bindAll(this, 'openedModalCreateEntity', 'closedModalCreateEntity', 'onNewEntity', 'responseValidateProgram');

			// extends parameters
            if( opts.parameters !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            //Init Attributes
            this.$modalCreateEntity = $('#modal-base-create-entity');
            this.configAlert = {
				'wrapper': '#main-wrap',
				'closeTime': 8000,
				'speedOpen': 500,
				'speedClose': 500
			};

            // Events Listener custome
            this.$modalCreateEntity.off('open.fndtn.reveal', this.openedModalCreateEntity);
            this.$modalCreateEntity.off('closed.fndtn.reveal', this.closedModalCreateEntity);
            this.$modalCreateEntity.on('open.fndtn.reveal', this.openedModalCreateEntity);
            this.$modalCreateEntity.on('closed.fndtn.reveal', this.closedModalCreateEntity);
		},

		/*
		* Render View Element
		*/
		render: function () {

			var attributes = this.parameters.programModel.toJSON();
			attributes['url_convocatoria'] = this.parameters.url_convocatoria;
			attributes['step'] = this.parameters.step;
			
			this.$el.html( this.template(attributes) );

			// Initialize attributes
			this.$selectEntities = this.$('.choice-entities-program');

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				$(document).foundation('tooltip', 'reflow');
			}

			return this;
		},

		/**
		* on opened modal
		*/
		openedModalCreateEntity: function (e) {
			if(e.namespace != 'fndtn.reveal') {
                return;
            }

			var $formCreateEntity = this.$modalCreateEntity.find('#form-create-entity');

			$formCreateEntity.data('type', 'program');

			$formCreateEntity.off('saved');
			$formCreateEntity.on('saved', this.onNewEntity);
		},

		/**
		* on closed modal
		*/
		closedModalCreateEntity: function (e) {
			if(e.namespace != 'fndtn.reveal') return;

			var $formCreateEntity = this.$modalCreateEntity.find('#form-create-entity');

			$formCreateEntity.removeData('type');
			$formCreateEntity.off('saved');
		},

		/**
		* handler event when a new entity was created
		* @param Object event
		* @param Object modelEntity
		*/
		onNewEntity: function (event, modelEntity) {
			if( !_.isObject(modelEntity) || !(modelEntity instanceof Backbone.Model) ) {
				return;
			}

            if(this.parameters.select.length){
                this.$selectEntities = this.parameters.select;
            }

			this.newEntity = modelEntity;

			// add option to entities select
			this.$selectEntities.append('<option value="'+ modelEntity.get('codigo_usuario') +'" selected>'+ modelEntity.get('nombre_usuario') +'</option>');
			this.$selectEntities.trigger('change');

			// reload select materialize
			if( this.$selectEntities.hasClass('initialized') ) {
                this.$selectEntities.material_select();
            }

			// close create entity modal
			this.$modalCreateEntity.foundation('reveal', 'close');
		},

		/**
		* on choice entity
		*/
		onChoiceEntity: function (e) {

			var codEntity = $(e.target).find('option:selected').val();

			window.Misc.setSpinner( this.$('#content-data-entity-program') );
			$.get(
				window.Misc.urlFull( Route.route('convocatoria.aplicar.validacion', {codigo_convocatoria: this.parameters.programModel.get('codigo_convocatoria'), codigo_usuario: codEntity}) ),
				this.responseValidateProgram
			)
			.fail(function() {
				window.Misc.removeSpinner({
					'wrap': this.$('#content-data-entity-program'),
					'direct': true
				});
			}.bind(this));
		},

		/**
		* Handler responsive validate program
		* @param Object resp
		*/
		responseValidateProgram: function (resp) {

			if( resp.success !== undefined ) {

				var type = resp.success ? 'success' : 'alert',
					text = resp.success ?
						   (resp.message !== undefined ? resp.message : '')
						   : resp.errors;

				if( _.isObject(resp.errors) ){
					var listError = '<ul>';

					$.each(resp.errors, function(field, item) {
						 listError += '<li>'+ item[0] +'</li>';
					});
					listError += '</ul>';
					text = listError;
				}

				var conf = {
					'text': text,
					'type': type
				};

				_.extend(this.configAlert, conf);

				// validate responsive success
				if( resp.success ) {

					// if entity was applied
					if( resp.applied ) {
                    
						this.$('#content-data-entity-program').html( this.templateInvalid(_.extend({message: (resp.message || ''), no_cancel: (resp.no_cancel || '')}, this.parameters.programModel.toJSON())) );

					}else {

						if( this.editEntityProgram instanceof Backbone.View ) {
							this.editEntityProgram.stopListening();
							this.editEntityProgram.undelegateEvents();
						}

						// Render and fetch new entity
						this.model.idAttribute = 'url_nickname';
						this.model.set({'url_nickname': resp.url_nickname}, {'silent':true});

						this.editEntityProgram = new app.ApplyEditEntityProgramView({
							el: this.$('#content-data-entity-program'),
							model: this.model,
							parameters: this.parameters
						});
						this.editEntityProgram.trigger('getdata');
					}

				}else {
					window.Misc.showAlertBox(this.configAlert);
				}
			}
		}

	});

})(jQuery, this, this.document);
