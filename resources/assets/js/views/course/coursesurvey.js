/**
* Class CourseSurveyView extends of Backbone View
* @author TuProyecto || Desarrolladores :  @refo44
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.CourseSurveyView = Backbone.View.extend({
		el: '#survey-wrapper',
		events: {

		},
		parameters: {
            course: '', 
            survey: '',
            type: ''
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

			// Events Listener
			this.listenTo( this.model, 'change', this.render );
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );
            this.render();

		},

		/*
		* Render View Element
		*/
		render: function() {

			var attributes = this.model.toJSON();

            attributes.course = this.parameters.course;
            attributes.survey = this.parameters.survey;
            attributes.type = this.parameters.type;
             

			// fires plugins and functions
			this.ready();


			return this;
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



            this.render();
            this.renderForm();
		},

        /**
         * render form apply
         */
        renderForm: function () {

            //Init Attributes   
            this.modelApplySurvey = new app.SurveyModel();
            this.modelApplySurvey.idAttribute = 'url_encuesta';
            this.modelApplySurvey.set({'url_encuesta': this.parameters.survey}, {'silent':true});
            

         var sendParams = {
                'codigo_usuario': this.model.get('codigo_usuario')
            };

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

            _this = this;    
            this.modelApplySurvey.fetch({data: sendParams});
           
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


