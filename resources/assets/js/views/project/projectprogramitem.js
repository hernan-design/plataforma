/**
* Class ProjectProgramItemView extends of Backbone View
* @author TuProyecto || Desarrolladores : @xindykatalina, @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProjectProgramItemView = Backbone.View.extend({
        tagName: 'li',
        className: 'tab-title',
        template: _.template( ($('#item-program-preview-list-tpl').html() || '') ),
        events: {
        	'click .to-open-review': 'onOpenReview'
        },
        parameters: {
        	dataFilter: {},
        	'content-review': null,
			'owner': false
        },

        /**
        * Constructor Method
        */
        initialize: function(opts) {
        	_.bindAll(this, 'responseDataReview');

        	// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) ) {
				this.parameters = $.extend({},this.parameters, opts.parameters);
            }

            // Events Listener
            this.listenTo( this.model, "change", this.render );
        },

        /*
        * Render View Element
        */
        render: function(){


            var attributes = this.model.toJSON();

            console.log(attributes);

            this.$el.html( this.template(attributes) );

            // reference to elements


            // fire when all already is loaded
            this.ready();

            return this;
        },

        /**
		* fire libraries js
		*/
        ready: function () {
        	// reload plugin
			if( _.has($.fn, 'foundation') ) {
				$(document).foundation('tab', 'reflow');
				$(document).foundation('tooltip', 'reflow');
			}

			$('.collapsible').collapsible({
				accordion : true
			});
        },

        /**
		* on open review program
		*/
		onOpenReview: function (e) {
			e.preventDefault();

			var $elProgram = $(e.currentTarget),
				$elToRender = this.parameters['content-review'] && this.parameters['content-review'].length ? this.parameters['content-review'] : $('#content-review-program-project');

			$(document).foundation('tab', 'toggle_active_tab', $elProgram.parent());
			if( $('#project-program-review-'+ this.model.get('id_convocatoria') +'-tpl').length ) {

				window.Misc.setSpinner( $elToRender );
				$.get( window.Misc.urlFull( Route.route('encuesta.informe') ), {
					'codigo_usuario_encuesta': this.model.get('codigo_usuario_encuesta')

				}, this.responseDataReview).always(function() {

					window.Misc.removeSpinner({
						'wrap': $elToRender,
						'direct': false
					});
				}.bind(this));

			} else {
				// render program review form
				this.renderForm()
			}
		},

		/**
		* response of the review data
		* @param Object resp
		*/
		responseDataReview: function (resp) {

			var $elToRender = this.parameters['content-review'] && this.parameters['content-review'].length ? this.parameters['content-review'] : $('#content-review-program-project');

			var templateReview = _.template( ($('#project-program-review-'+ this.model.get('id_convocatoria') +'-tpl').html() || '') );

			console.log('respuesta', resp);

			$elToRender.html( templateReview(resp) );

			// fire when all already is loaded
			this.ready();
			this.buildCharts(resp);
		},

		/**
		* render review apply
		*/
		renderForm: function () {
			var sendParams = {
				'codigo_usuario_encuesta': this.model.get('codigo_usuario_encuesta')
            };

            var modelReviewSurvey = new app.SurveyModel();
			modelReviewSurvey.idAttribute = 'url_encuesta';
			modelReviewSurvey.set({'url_encuesta': this.model.get('url_encuesta')}, {'silent':true});

            // validate if is owner and also the time for editing is available, otherwise just preview
			if( this.parameters.owner && this.model.get('edicion_formulario_registro') && window.moment(this.model.get('fecha_edicion_formulario_registro')).add(1, 'd').diff(window.moment(), 'seconds', true) > 0 ) {
				if( this.surveyEditView instanceof Backbone.View ) {
					this.surveyEditView.stopListening();
					this.surveyEditView.undelegateEvents();
				}
				this.surveyEditView = new app.SurveyView({
					el: this.parameters['content-review'] && this.parameters['content-review'].length ? this.parameters['content-review'] : $('#content-review-program-project'),
					model: modelReviewSurvey,
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
					el: this.parameters['content-review'] && this.parameters['content-review'].length ? this.parameters['content-review'] : $('#content-review-program-project'),
					model: modelReviewSurvey,
					parameters: {
						params: sendParams,
						review: true
					}
				});
			}

			modelReviewSurvey.fetch({data: sendParams});
		},

		/**
		* build chart for the program resume
        * @param cdata { Object }
		*/
		buildCharts: function (cdata) {

            switch(this.model.get('codigo_institucion'))
            {
                case window._tp.getInstitution['dinamiza']:
                    if( $('#chart-area-result-program').length ) {
                        var $elAreaResult = $('#chart-area-result-program');

                        report = cdata.report;


                        reportData = report['data_general'];

                        var data = _.map(reportData['total_grupos'] , function(item){ return item.result });

                        var labels = reportData['titulos_grupo'];

                        var chartAreaResult = new Chart($elAreaResult, {
                            type: "radar",
                            data: {
                                labels: labels,
                                datasets: [{
                                    data: data,
                                    backgroundColor: "rgba(62,182,255,0.2)",
                                    borderColor: "rgb(62,182,255)",
                                    pointBackgroundColor: "rgb(62,182,255)",
                                    pointBorderColor: "#fff",
                                    pointHoverBackgroundColor: "#fff",
                                    pointHoverBorderColor: "rgb(62,182,255)",
                                    borderWidth: 1,
                                    pointRadius: 5
                                }]
                            },
                            options: {
                                legend: {
                                    display: false
                                },
                                title:{
                                    fontStyle:'bold',
                                    padding:14
                                },
                                scale: {
                                    ticks: {
                                        beginAtZero: true
                                    },
                                    pointLabels: {
                                        fontSize: 12
                                    }
                                }
                            }
                        });
                    }

                    break;

                case window._tp.getInstitution['cenisoft']:
                    if( $('#chart-area-result-program').length ) {
                        var $elAreaResult = $('#chart-area-result-program');

                        report = cdata.report;


                        reportData = report['data_general'];

                        var data = _.map(reportData['total_grupos'] , function(item){ return item.result });

                        var labels = reportData['titulos_grupo'];

                        var chartAreaResult = new Chart($elAreaResult, {
                            type: "radar",
                            data: {
                                labels: labels,
                                datasets: [{
                                    data: data,
                                    backgroundColor: "rgba(62,182,255,0.2)",
                                    borderColor: "rgb(62,182,255)",
                                    pointBackgroundColor: "rgb(62,182,255)",
                                    pointBorderColor: "#fff",
                                    pointHoverBackgroundColor: "#fff",
                                    pointHoverBorderColor: "rgb(62,182,255)",
                                    borderWidth: 1,
                                    pointRadius: 5
                                }]
                            },
                            options: {
                                legend: {
                                    display: false
                                },
                                title:{
                                    fontStyle:'bold',
                                    padding:14
                                },
                                scale: {
                                    ticks: {
                                        beginAtZero: true
                                    },
                                    pointLabels: {
                                        fontSize: 12
                                    }
                                }
                            }
                        });
                    }

                    break;


                case window._tp.getInstitution['innpulsa']:
                    if( $('#chart-area-result-program').length ) {
                        var $elAreaResult = $('#chart-area-result-program');

                        var chartAreaResult = new Chart($elAreaResult, {
                            type: "radar",
                            data: {
                                labels: ["Gestión administrativa", "Gestión humana y cultura de la innovación", "Gestión financiera", "Gestión comercial", "Gestión de la producción"],
                                datasets: [{
                                    label: 'Mi promedio',
                                    data: [cdata.report.data_admin_management.score,
                                        cdata.report.data_human_management.score,
                                        cdata.report.data_financial_management.score,
                                        cdata.report.data_commercial_management.score,
                                        cdata.report.data_production_management.score
                                    ],
                                    backgroundColor: "rgba(62,182,255,0.2)",
                                    borderColor: "rgb(62,182,255)",
                                    pointBackgroundColor: "rgb(62,182,255)",
                                    pointBorderColor: "#fff",
                                    pointHoverBackgroundColor: "#fff",
                                    pointHoverBorderColor: "rgb(62,182,255)",
                                    borderWidth: 1,
                                    pointRadius: 5
                                },
                                    {
                                        label: 'Promedio general',
                                        data: [cdata.report.data_admin_management.score_general,
                                            cdata.report.data_human_management.score_general,
                                            cdata.report.data_financial_management.score_general,
                                            cdata.report.data_commercial_management.score_general,
                                            cdata.report.data_production_management.score_general
                                        ],
                                        backgroundColor: "rgba(58,58,58,0.2)",
                                        borderColor: "rgb(58,58,58)",
                                        pointBackgroundColor: "rgb(58,58,58)",
                                        pointBorderColor: "#fff",
                                        pointHoverBackgroundColor: "#fff",
                                        pointHoverBorderColor: "rgb(58,58,58)",
                                        borderWidth: 1,
                                        pointRadius: 5
                                    },
                                    {
                                        label: 'Promedio por sector',
                                        data: [cdata.report.data_admin_management.score_economy,
                                            cdata.report.data_human_management.score_economy,
                                            cdata.report.data_financial_management.score_economy,
                                            cdata.report.data_commercial_management.score_economy,
                                            cdata.report.data_production_management.score_economy
                                        ],
                                        backgroundColor: "rgba(186,100,39,0.2)",
                                        borderColor: "rgb(186,100,39)",
                                        pointBackgroundColor: "rgb(186,100,39)",
                                        pointBorderColor: "#fff",
                                        pointHoverBackgroundColor: "#fff",
                                        pointHoverBorderColor: "rgb(186,100,39)",
                                        borderWidth: 1,
                                        pointRadius: 5
                                    }]
                            },
                            options: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        usePointStyle: true,
                                        fontSize: 12,
                                        padding: 30,
                                        boxWidth: 15
                                    }
                                },
                                scale: {
                                    ticks: {
                                        beginAtZero: true
                                    },
                                    pointLabels: {
                                        fontSize: 12
                                    }
                                }
                            }
                        });
                    }
                    break;
            }

		}
    });

})(jQuery, this, this.document);
