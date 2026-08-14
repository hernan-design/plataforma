/**
* Class SurveyReview extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function  ($, window, document, undefined) {

    app.SurveyReview = app.SurveyView.extend({
        el: '#survey-content',
        template: _.template( ($('#survey-review-tpl').html() || '') ),
        events: {
            'click .page-next-survey': 'onNextPage',
            'click .page-prev-survey': 'onPrevPage'
        },
        parameters: {
	        'dataFilter' : {},
			'pageSize': 10,
			'typeSurvey': 'pageable',
			'review': true,
			'params': {},
			'confirmBtn': true
        },

        /**
        * Constructor Method
        */
        initialize: function (opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

			// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) )
				this.parameters = $.extend({}, this.parameters, opts.parameters);

			// Init Attributes
			this.$contentQuestions = null;
			this.surveyQuestions = new app.surveyQuestionsList();
			this.showHideQuestions = [];
			this.configAlert = {
				'wrapper': '#main-wrap',
				'closeTime': 8000,
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

			// Events Listeners
			this.listenTo(this.model, 'change:codigo_encuesta', this.render);
			this.listenTo(this.model, 'change:preguntas', this.renderQuestions);
			this.listenTo(this.model, 'request', this.loadSpinner);
			this.listenTo(this.model, 'sync', this.responseServer);
			// this.listenTo(this.surveyQuestions, 'add', this.addOne);
			this.listenTo(this.surveyQuestions, 'reset', this.addAll);

			this.on('beforeRender', this.beforeRender);
			this.on('afterRender', this.afterRender);
        },

        /**
        * Render View Element
        */
        render: function () {
            var attributes = this.model.toJSON();
            attributes.review = this.parameters.review;
            // console.log('Survey Review', attributes);

            this.$el.html( this.template(attributes) );

            // Initialize renference to elements
            this.$contentQuestions = this.$('#content-asked-questions');
            this.$btnsActions = this.$('.buttons-action-survey');
            this.$wrapPagination = this.$('.wrap-pagination');

            // overwrite model id attribute
            if( this.model.changed.codigo_encuesta !== undefined ) {
                this.model.idAttribute = 'codigo_encuesta';
                this.model.set({ 'codigo_encuesta': this.model.get('codigo_encuesta') }, {'silent':true} );

                // redefine the URI
                this.model.returnToUrlRoot();

                // this.renderQuestions();
            }

            // set paginations
			this.$wrapPagination.each(function(index, el) {

				var pagination = new app.Paginator({
					className: 'right pagination tablet-text-right',
					collection: this.surveyQuestions,
					parameters: {
						'data': this.parameters.dataFilter
					}
				});
				$(el).html( pagination.render().el );

			}.bind(this));
        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function ( target ) {

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

            // response success or error
            var text = !resp.success ? resp.errors: resp.message || '',
                type = resp.success ? 'success' : 'alert';

            if( _.isObject(resp.errors) ) {

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
            }, conf = $.extend({}, this.configAlert, config );

            // complete proccess
            if( resp.success != undefined ) {
                if( !resp.success ) {
                    window.Misc.showAlertBox( conf );
                }
            }
        }
    });

})(jQuery, this, this.document);
