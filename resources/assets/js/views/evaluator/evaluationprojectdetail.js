/**
* Class EvaluationProjectDetailView extends of Backbone View
* @author TuProyecto || Desarrolladores : @xindykatalina, @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.EvaluationProjectDetailView = Backbone.View.extend({

		el: '#evaluation-inner-content',
		template: _.template( ($('#evaluation-detail-tpl').html() || '') ),
		templateProject: _.template( ($('#project-info-tpl').html() || '') ),
		templateIndustry: _.template( ($('#info-industry-project-tpl').html() || '') ),
		templateTotalEvaluation: _.template( ($('#total-evaluation-tpl').html() || '') ),
		templateAcomulatedAverage: _.template( ($('#acomulated-average-evaluation-tpl').html() || '') ),
		events: {
			'submit #form-evaluation-project': 'onStore',
			'click .to-return-evaluation': 'onReturnStage',
			'click .edit-field': 'onRenderToEdit'
		},
		parameters: {
		  //
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender');

			// extends parameters
			if( opts.parameters !== undefined && _.isObject(opts.parameters) )
				this.parameters = $.extend({}, this.parameters, opts.parameters);

			// Init Attributes
			this.itemEvaluationList = new app.ItemEvaluationList();
			this.modelReviewSurvey = new app.SurveyModel();
			this.modelProject = new app.ProjectModel();
			this.$contentQuestions = null;

			this.configAlert = {
				'wrapper': '#main-wrap',
				'closeTime': 6000,
				'speedOpen': 500,
				'speedClose': 500
			};

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			// Events Listener
			this.listenTo( this.model, 'change:id_proyecto', this.render );
			this.listenTo( this.model, 'change:valor_total_evaluacion', this.renderTotalEvaluation );
			this.listenTo( this.model, 'change:promedio_acumulado', this.renderAcomulatedAverage );
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );
			this.listenTo( this.modelProject, 'change:codigo_entidad', this.renderInfoProject );
			this.listenTo( this.modelProject, 'request', this.loadSpinnerInfoProject );
			this.listenTo( this.itemEvaluationList, 'reset', this.addAll);

			// Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );

		},

		/*
		* Render View Element
		*/
		render: function() {
			var _this = this,
			attributes = this.model.toJSON();
			console.log('Attributes Template', attributes);
			this.$el.html( this.template(attributes) );

			// Initialize reference to elements
			this.$contentQuestions = this.$('#container-item-evaluation');
			this.$contentProgramReview = this.$('#evaluation-project-program-review');

			// overwrite model id attribute
			if( this.model.changed.id_proyecto !== undefined ) {
				// render template total evaluation
				this.renderTotalEvaluation();

				// fetch project data
				this.modelProject.idAttribute = 'url_nickname';
				this.modelProject.set({'url_nickname': this.model.get('nickname_usuario_proyecto')}, {'silent':true});
				this.modelProject.fetch();

				$(window).scrollTop(0);
			}
			this.itemEvaluationList.reset(this.model.get('grupos'));
		},

		/**
		* Render view project
		*/
		renderInfoProject: function () {

			var attributes = this.modelProject.toJSON();
			attributes.visibilidad_aplicacion = this.model.get('visibilidad_aplicacion');
			console.log('Attributes Project', attributes);
			this.$('#info-project-evaluation').html( this.templateProject(attributes) );

			if( this.modelProject.changed.codigo_entidad !== undefined ) {
				// Overwrite id attribute of the model
				this.modelProject.idAttribute = 'codigo_entidad';
				this.modelProject.set({'codigo_entidad': this.modelProject.get('codigo_entidad')}, {'silent':true});

				// render template industry
				this.renderInfoIndustry();
			}

			// summary project for view more
			window.Misc.showMore({'container': this.$('.description-project-evaluation'), 'maxlen': 350});

			this.ready();
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function () {
			//
		},

		/**
		* Fires before of run render function
		*/
		afterRender: function () {

			this.ready();

			// Render review program answers
			this.renderReviewAnswers();

		},

		/**
		* fires libraries js
		*/
		ready: function () {

			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				$(document).foundation('abide', 'reflow');
				$(document).foundation('tab', 'reflow');
				$(document).foundation('dropdown', 'reflow');
			}

			// reload plugins
			if( typeof window.initComponent.select2Trigger == 'function' && _.has($.fn, 'select2') )
				window.initComponent.select2Trigger();

			if( typeof window.initComponent.initConfigForm == 'function' )
				window.initComponent.initConfigForm();
		},

		/**
		* render review project program
		*/
		renderReviewAnswers: function () {
			var sendParams = {
				'codigo_usuario_encuesta': this.model.get('codigo_usuario_encuesta')
			};

			this.modelReviewSurvey.idAttribute = 'url_encuesta';
			this.modelReviewSurvey.set({'url_encuesta': this.model.get('url_encuesta')}, {'silent':true});

			if( this.surveyReviewView instanceof Backbone.View ) {
				this.surveyReviewView.stopListening();
				this.surveyReviewView.undelegateEvents();
			}

			this.surveyReviewView = new app.SurveyReview({
				el: this.$contentProgramReview,
				model: this.modelReviewSurvey,
				parameters: {
					params: sendParams,
					review: true,
					confirmBtn: false
				}
			});
			this.modelReviewSurvey.fetch({data: sendParams});
			this.wasRenderForm = true;
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function () {
			 window.Misc.setSpinner( this.$el );
		},

		/**
		* Load spinner on the request
		*/
		loadSpinnerInfoProject: function () {

			if( !this.modelProject.changed.codigo_entidad )
			 	window.Misc.setSpinner( this.$('#info-project-evaluation') );
		},

		/**
		* response of the server
		*/
		responseServer: function ( model, resp, opts ) {

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
						if(re.success != undefined) {
							if( re.success ){
								window.Misc.showAlertBox( conf );

								window.location.reload();
							}else{
								window.Misc.showAlertBox( conf );
							}
						}
					}
				})(this.configAlert, resp, this)
			});
			
		},

		/**
		* Render view question by model
		* @param Object itemEvaluationModel Model instance
		*/
		addOne: function (itemEvaluationModel, collection, opts) {

			var view = new app.EvaluationItemView({
				model: itemEvaluationModel,
				parameters: {
					'options': this.model.get('options'),
					'evaluation': this.model.get('evaluation'),
					'subgrupos_evaluacion_emprendimiento': this.model.get('subgrupos_evaluacion_emprendimiento'),
					'nombre_evaluacion': this.model.get('nombre_evaluacion')
				}
			});

			this.$contentQuestions.append( view.render().el );
		},

		/**
		* Render all view question of the collection
		*/
		addAll: function () {

			this.$contentQuestions.html('');
			this.itemEvaluationList.forEach( this.addOne, this );
		},

		/**
		* Event Evaluation Entrepreneurship
		*/
		onStore: function (e) {
			e.preventDefault();

			var _this = this;
			var data = window.Misc.formToJson( e.target );
			this.$el.find('#url_attached_171').val('Otro cambio');
			data.codigo_evaluacion_emprendimiento = this.model.get('codigo_evaluacion_emprendimiento');
			data.codigo_asignacion_jurado = this.model.get('codigo_asignacion_jurado');
			data.seg_codigo_usuario = this.model.get('seg_codigo_usuario');
			data.evaluation = this.model.get('evaluation');
			data.url_fase = this.model.get('url_fase');

			this.model.save( data, {patch: true, wait:true, success: function (model, resp, opts) {

				_this.itemEvaluationList.set( _this.model.get('grupos'), {merge:true, remove:false, add:false} );

			}} );
		},

		/**
		* render total evaluation
		*/
		renderTotalEvaluation: function (model, value, opts) {

			this.$('#total-evaluation-container').html( this.templateTotalEvaluation(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render acomulated average
		*/
		renderAcomulatedAverage: function () {
			this.$('#content-acomulated-average').html( this.templateAcomulatedAverage(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info Industry
		*/
		renderInfoIndustry: function (model, value, opts) {
			this.$('#project-industry-evaluator-container').html( this.templateIndustry(this.modelProject.toJSON()) );
			this.ready();
		},

		/**
		* return project stage to previous stage
		*/
		onReturnStage: function (e) {
			e.preventDefault();

			var data = { };

			// Confirm cancel
			this.confirmReturnStage = new app.ConfirmWindow({
				model: this.model,
				parameters: {
					template: _.template( ($('#return-evaluation-confirm-tpl').html() || '') ),
					titleConfirm : '¡Devolver emprendimiento!',
					dataFilter: _.extend({}, data),
					callBack: function (respStage, dataFilter) {

						if(respStage) {
							app.AppRouter.navigate( Route.route('evaluacion.index'), {trigger: true} );
						}
					}
				}
			});
			this.confirmReturnStage.render();
		},

		/**
		* render to edit industry
		*/
		onRenderToEdit: function (e) {
			e.preventDefault();
			var _this = this;

			this.modelProject.url = function () {
				return window.Misc.urlFull( Route.route('evaluacion.categoria', {entity: _this.modelProject.get('codigo_entidad')}) );
			};

			var templateRender = $(e.currentTarget).data('edit-template') || '',
				setViewEdit = {
					'industry-project': function () {
						if( app.ProjectEditIndustry === undefined )
							return

						if( _this.projectEditIndustryView instanceof Backbone.View ){
							_this.projectEditIndustryView.stopListening();
							_this.projectEditIndustryView.undelegateEvents();
						}

						_this.projectEditIndustryView = new app.ProjectEditIndustry({
							model: _this.modelProject,
							parameters: {
								dropdown: '#'+ $(e.currentTarget).data('dropdown')
							}
						});

						$( '#'+ $(e.currentTarget).data('dropdown') ).html( _this.projectEditIndustryView.render().el );

						// refresh plugis
						_this.ready();
					},

					default: function () {
						//
					}
				};

			if (setViewEdit[templateRender]) {
                setViewEdit[templateRender]();
            } else {
                setViewEdit['default']();
            }
		}
   });

})(jQuery, this, this.document);
