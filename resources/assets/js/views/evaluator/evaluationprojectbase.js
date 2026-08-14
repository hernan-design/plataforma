/**
* Class EvaluationProjectBaseView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function  ($, window, document, undefined) {

	app.EvaluationProjectBaseView = Backbone.View.extend({
		el: '#evaluation-project-content',
		template: _.template( ($('#evaluation-project-base-tpl').html() || '') ),
		events: {
            // 
		},
		parameters: {
			section: '',
            evaluation: null,
			dataFilter: {}
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {
			 _.bindAll(this, 'beforeRender', 'render', 'afterRender');

			// extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) )
				this.parameters = $.extend({}, this.parameters, opts.parameters);

			// Init attributes
			this.evaluationList = new app.ProjectEvaluationList();

			var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

			// Events Listeners
            this.on('beforeRender', this.beforeRender);
            this.on('afterRender', this.afterRender);
		},

		/**
		* Render view element
		*/
		render: function () {
			var attributes = {
                section: this.parameters.section
			};

			this.$el.html( this.template(attributes) );

			// to switch section
			this.switchSection( this.parameters.section );

			return this;
		},

        /**
        * Fires before of run render function
        */
        beforeRender: function() {
            // code goes here
        },

        /**
        * Fires before of run render function
        */
        afterRender: function() {

            this.ready();
        },

        /**
        * fires libraries js
        */
        ready: function () {

            var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
                $(document).foundation();
                $(document).foundation('tab', 'reflow');
            }

			// reload plugins
			if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
				window.initComponent.chosenTrigger();

			if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
				window.initComponent.select2Trigger();

			if( typeof window.initComponent.initConfigForm == 'function' )
				window.initComponent.initConfigForm();
        },

		/**
		* reference to sections views mentoring
		*/
		referenceToSections: function () {

		},

		/**
		* switch sections
		*/
		switchSection: function (toSection) {
			var _this = this;

			var switchSection = {
				'evaluationList': function (params) {
					_this.getEvaluationList();
				},

                'evaluation': function (params) {
					_this.getEvaluation();
				},

				'default': function (params) {
					_this.getEvaluationList();
				}
			}

			if( switchSection[toSection] ) {
				switchSection[toSection]();
			}else {
				switchSection['default']();
			}
		},

		/**
		* get evaluations list
		*/
		getEvaluationList: function () {

			if( this.evaluationListView instanceof Backbone.View ) {
				this.evaluationListView.stopListening();
				this.evaluationListView.undelegateEvents();
			}

			this.evaluationListView = new app.EvaluationProjectListView({
				el: this.$('#evaluation-inner-content'),
				collection: this.evaluationList,
				parameters: { dataFilter: this.parameters.dataFilter}
			});
			this.evaluationListView.render();
			this.evaluationListView.trigger('getData');
		},

        /**
		* get evaluation detail
		*/
		getEvaluation: function () {
            this.projectEvaluationModel = new app.ProjectEvaluationModel();
            this.projectEvaluationModel.set({'url_asignacion_jurado': this.parameters.evaluation}, {'silent':true});

            if ( this.evaluationProjectDetailView instanceof Backbone.View ){
                this.evaluationProjectDetailView.stopListening();
                this.evaluationProjectDetailView.undelegateEvents();
            }

            this.evaluationProjectDetailView = new app.EvaluationProjectDetailView({ model: this.projectEvaluationModel });
            this.projectEvaluationModel.fetch();
        }
	});

})(jQuery, this, this.document);
