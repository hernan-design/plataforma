/**
* Class ApplyFormProgramView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ApplyFormProgramView = Backbone.View.extend({
		el: '#apply-survey-program',
		template: _.template( ($('#survey-apply-program-tpl').html() || '') ),
		events: {

		},
		parameters: {
			url_convocatoria: '',
			step: '',
			entityModel: null
		},

		/**
		* Constructor Method
		*/
		initialize: function (opts) {

			// extends parameters
            if( opts.parameters !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

            //Init Attributes
            this.modelApplySurvey = new app.SurveyModel();
		},

		/*
		* Render View Element
		*/
		render: function () {

			var attributes = this.model.toJSON();
			attributes['url_convocatoria'] = this.parameters.url_convocatoria;
            attributes['step'] = this.parameters.step;

            // Initialize attributes

			this.$el.html( this.template(attributes) );
			this.renderForm();

			// reload plugins
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
				$(document).foundation('tooltip', 'reflow');
				$(document).foundation('dropdown', 'reflow');
			}

			// trigger libraries
			if( typeof window.initComponent.select2Trigger == 'function' && _.has($.fn, 'select2') )
				window.initComponent.select2Trigger();

			if( typeof window.initComponent.initConfigForm == 'function' )
				window.initComponent.initConfigForm();

			return this;
		},

		/**
		* render form apply
		*/
		renderForm: function () {
			
			var sendParams = {
				'codigo_usuario': this.parameters.entityModel ? this.parameters.entityModel.get('codigo_usuario') : 0,
				'codigo_convocatoria': this.model.get('codigo_convocatoria')
			};

			this.modelApplySurvey.idAttribute = 'url_encuesta';
			this.modelApplySurvey.set({'url_encuesta': this.model.get('url_encuesta')}, {'silent':true});

			if( this.surveyView instanceof Backbone.View ) {
				this.surveyView.stopListening();
				this.surveyView.undelegateEvents();
			}

			this.surveyView = new app.SurveyView({
				el: this.$('#survey-content'),
				model: this.modelApplySurvey,
				parameters: {
					params: sendParams
				}
			});
			this.modelApplySurvey.fetch({data: sendParams});
		}
	});

})(jQuery, this, this.document);
