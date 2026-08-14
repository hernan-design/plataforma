/**
* Class EvaluationItemView extend of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.EvaluationItemView = Backbone.View.extend({

		tagName: 'dd',
		template: _.template( ($('#evaluation-item-tpl').html() || '') ),
		events: {
            'click .group263': 'onValidateRequired',
            'click .group257': 'onValidateRequired1',
		},
		parameters: {
			renderTemplate: '',
			options: [],
			evaluation: false,
			subgrupos_evaluacion_emprendimiento: false
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts){
			_.bindAll(this, 'beforeRender', 'render', 'afterRender');

			// Extend options parameters
			if( opts !== undefined && _.isObject(opts.parameters) )
				this.parameters = _.extend({}, this.parameters, opts.parameters);

			//Init Attributes
			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			// Events Listener
			this.listenTo( this.model, "change", this.render );
			this.listenTo( this.model, 'destroy', this.remove );
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );

			// Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );
		},

		/*
		* Render View Element
		*/
		render: function(model){

			var attributes = this.model.toJSON();
			attributes.options = this.parameters['options'];
			attributes.evaluation = this.parameters['evaluation'];
			attributes.subgrupos_evaluacion_emprendimiento = this.parameters['subgrupos_evaluacion_emprendimiento'];
			attributes.nombre_evaluacion = this.parameters['nombre_evaluacion'];

			console.log('Attributes questions', attributes);

			this.$el.html( this.template(attributes) )
					.fadeIn('slow');

			this.referenceViews();
		},

		referenceViews: function() {
			var attributes = this.model.toJSON(), _this = this;

			_.each(attributes.items, function (item) {
				_this.$wrapperDocuments = _this.$('#wrap-documents-' + item.codigo_item_evaluacion);

				switch (item.codigo_tipo_evaluacion_item) {
					case window._tp.typeItemEvaluation[('upload')]:
						this.evaluationUploader = new app.EvaluationItemDocument({
							el: _this.$wrapperDocuments,
							model: _this.model,
							parameters: {
								codigo_item_evaluacion: item.codigo_item_evaluacion
							}
						});
						this.evaluationUploader.render();
					break;
				}
			});
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

			var _this = this;
			// reflow foundation plugins
			if( _.has($.fn, 'foundation') ){
				$(document).foundation('abide', 'reflow');
			}

			// reload plugins
			if( typeof window.initComponent.select2Trigger == 'function' && _.has($.fn, 'select2') )
				window.initComponent.select2Trigger();

			if( typeof window.initComponent.initConfigForm == 'function' )
				window.initComponent.initConfigForm();

			if( typeof window.initComponent.validateFormForEdit == 'function' )
				window.initComponent.validateFormForEdit();
		},

		/*
		* Remove View Element
		*/
		remove: function(){
			var _this = this;
			this.$el.fadeOut('slow', function (){
				$(this).remove();
			});
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

		onValidateRequired: function (e) {
			var inputs = $('.group263');
			var isChecked = inputs.is(':checked'); 
			inputs.each(function () {
				if (isChecked) {
				  $(this).removeAttr('required'); // Si hay un checkbox seleccionado, se elimina el atributo required
				} else {
				  $(this).prop('required', true); // Si ninguno está seleccionado, se agrega el atributo required
				}
			});
		},

		onValidateRequired1: function (e) {
			var inputs = $('.group257');
			var isChecked = inputs.is(':checked'); 
			inputs.each(function () {
				if (isChecked) {
				  $(this).removeAttr('required'); // Si hay un checkbox seleccionado, se elimina el atributo required
				} else {
				  $(this).prop('required', true); // Si ninguno está seleccionado, se agrega el atributo required
				}
			});
		},
   });

})(jQuery, this, this.document);
