/**
* Class ProjectBusinessModelView of Backbone View
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ProjectBusinessModelView = Backbone.View.extend({

		el: '#project-business-model',
		template: _.template( ($('#project-section-business-model-tpl').html() || '') ),
		events: {
			//
		},
		parameters: {
			entityModel: null,
			dataFilter: {}
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts){

			// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) )
				this.parameters = $.extend({},this.parameters, opts.parameters);

            //Init Attributes
            this.modelReviewSurvey = new app.SurveyModel();

            // Events Listener
            this.listenTo( this.model, "change", this.render );
            this.listenTo( this.model, 'request', this.loadSpinner);
			this.listenTo( this.model, 'sync', this.responseServer);
		},

		/*
		* Render View Element
		*/
		render: function(){

			var attributes = {},
				_this = this;

			this.$el.html( this.template(attributes) );

			// fire when all already is loaded
			this.ready();
            this.renderForm();
			return this;
		},

		/**
		* fire libraries js
		*/
		ready: function () {

			// reload plugin
			if( _.has($.fn, 'foundation') ) {
				$(document).foundation('tab', 'reflow');
			}

			$('.scrollspy').scrollSpy();
		},

		/**
		* render review apply
		*/
		renderForm: function () {
			var sendParams = {
                    'codigo_usuario_encuesta': !_.isUndefined( this.model.get('codigo_usuario_encuesta') ) ? this.model.get('codigo_usuario_encuesta') : '',
                    'codigo_entidad': this.parameters.entityModel.get('codigo_entidad'),
                    'codigo_usuario': this.parameters.entityModel ? this.parameters.entityModel.get('codigo_usuario') : 0,
                    'module': 'projects'
                },
                owner = this.parameters.entityModel ?
                        (this.parameters.entityModel.get('owner') || this.parameters.entityModel.get('creator')) : false;

			this.modelReviewSurvey.idAttribute = 'url_encuesta';
			this.modelReviewSurvey.set({'url_encuesta': this.model.get('url_encuesta')}, {'silent':true});

            // validate if is owner and also the time for editing is available, otherwise just preview
			if( owner ) {
				if( this.surveyEditView instanceof Backbone.View ) {
					this.surveyEditView.stopListening();
					this.surveyEditView.undelegateEvents();
				}
				this.surveyEditView = new app.SurveyView({
					el: $('#content-review-business-model-project'),
					model: this.modelReviewSurvey,
					parameters: {
						params: sendParams
					}
				});
			}else {
				if( this.surveyReviewView instanceof Backbone.View ) {
					this.surveyReviewView.stopListening();
					this.surveyReviewView.undelegateEvents();
				}
				this.surveyReviewView = new app.SurveyReview({
					el: $('#content-review-business-model-project'),
					model: this.modelReviewSurvey,
					parameters: {
						params: sendParams,
						review: true
					}
				});
			}

			this.modelReviewSurvey.fetch({data: sendParams});
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
		responseServer: function ( target, resp, opts ) {

			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false
			});
		}
   });

})(jQuery, this, this.document);
