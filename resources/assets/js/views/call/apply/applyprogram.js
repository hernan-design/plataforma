/**
* Class ApplyProgramView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ApplyProgramView = Backbone.View.extend({
		el: '#calls-content',
		template: _.template( ($('#wrapper-apply-program-tpl').html() || '') ),
		events: {
			'click .get-apply-terms-program': 'onGetTerms',
			'click .get-apply-entity-program': 'onGetEntity',
			'click .get-apply-survey-program': 'onGetForm'
		},
		parameters: {
			url_convocatoria: '',
			step: '',
			dataFilter: {}
		},

		/**
		* Constructor Method
		*/
		initialize: function (opts) {
			this.setElement(this.$el)

			_.bindAll(this, 'beforeRender', 'render', 'afterRender');

			// extends parameters
            if( opts.parameters !== undefined && _.isObject(opts.parameters) )
                this.parameters = $.extend({}, this.parameters, opts.parameters);

			//Init Attributes
			this.programModel = new app.CallModel();
			this.entityModel = new app.ProjectModel();
			this.userModel = new app.UserModel();
			this.programModel.idAttribute = 'url_convocatoria';
			this.programModel.set({'url_convocatoria': this.parameters.url_convocatoria}, {'silent':true});

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			// Events Listener
			this.listenTo( this.programModel, 'change', this.render );
			this.listenTo( this.programModel, 'request', this.loadSpinner );
			this.listenTo( this.programModel, 'sync', this.responseServer );
			this.listenTo( this.entityModel, 'change:codigo_usuario', this.fetchedEntity );
			this.listenTo( this.userModel, 'change:codigo_usuario', this.fetchedEntity );

			// Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );
			this.on( 'getdata', this.getFirstData );
		},

		/*
		* Render View Element
		*/
		render: function () {

			var attributes = this.programModel.toJSON();
			attributes['url_convocatoria'] = this.parameters.url_convocatoria;
			attributes['step'] = this.parameters.step;
            console.log('attributes');
			// Initialize attributes

			this.$el.html( this.template(attributes) );


			// reference to views
			this.referenceToViews();
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function () {

		},

		/**
		* Fires before of run render function
		*/
		afterRender: function () {

			// to check apply program step
            if( this.parameters.step.length ){
                this.switchStep( this.parameters.step );
            }

			this.ready();
		},

		/**
        * get reset data
        * @param dataFilter Object
        * @param replace Boolean
        */
        getFirstData: function  (dataFilter, replace) {

            dataFilter || (dataFilter = {});
            replace || (replace = false);

            if(replace) {
                this.parameters.dataFilter = dataFilter;
            }else{
                _.extend( this.parameters.dataFilter, dataFilter );
            }

            this.programModel.fetch( {data:_.clone(this.parameters.dataFilter)} );
        },

		/**
		* fires libraries js
		*/
		ready: function () {
			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
				$(document).foundation('tab', 'reflow');
			}

			// reload plugins
			if( typeof window.initComponent.select2Trigger == 'function' && _.has($.fn, 'select2') )
				window.initComponent.select2Trigger();

			if( typeof window.initComponent.configScrollbar == 'function' && _.has($.fn, 'perfectScrollbar') )
				window.initComponent.configScrollbar();

			if( typeof window.initComponent.initConfigForm == 'function' )
				window.initComponent.initConfigForm();

			if( typeof window.initComponent.initTabs == 'function' )
				window.initComponent.initTabs();
		},

		/**
        * reference to instance views
        */
		referenceToViews: function () {
			// terms apply program view
			this.applyTermsView = new app.ApplyTermsProgramView({
				el: this.$('#apply-terms-program'),
				model: this.programModel,
				parameters: _.extend({applyProgramView: this}, this.parameters)
			});

			// entity apply program view
			this.applyEntityView = new app.ApplyEntityProgramView({
				el: this.$('#apply-entity-program'),
				model: this.entityModel,
				parameters: _.extend({applyProgramView: this, programModel: this.programModel}, this.parameters)
			});

			// user apply program view
			this.applyUserView = new app.ApplyUserProgramView({
				el: this.$('#apply-entity-program'),
				model: this.userModel,
				parameters: _.extend({applyProgramView: this, programModel: this.programModel}, this.parameters)
			});
		},

		/**
		* get a entity model
		* @param entityModel Object
		*/
		fetchedEntity: function (entityModel) {
			// form apply program view
			this.applyFormView = new app.ApplyFormProgramView({
				el: this.$('#apply-survey-program'),
				model: this.programModel,
				parameters: _.extend({applyProgramView: this, entityModel: entityModel}, this.parameters)
			});
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function () {
			window.Misc.setSpinner( this.$('#contents-apply-program') );
		},

		/**
		* response of the server
		*/
		responseServer: function ( model, resp, opts ) {
			window.Misc.removeSpinner({
				'wrap': this.$('#contents-apply-program'),
				'direct': true
			});
		},

		/**
		* render step apply program
		* @param String step
		*/
		switchStep: function (step) {
			var _this = this,
                switchStep = {
                    'terminos' : function() {
                        _this.getTerms();
                    },
                    'entidad' : function() {
                        _this.getEntity();
                    },
                    'formulario' : function() {
                        _this.getForm();
                    },
                    'default': function () {
                        _this.getTerms();
                    }
                };

            if (switchStep[step]) {
                switchStep[step]();
                this.isDefault = false;

            } else {
                switchStep['default']();
                this.isDefault = true;
            }
		},

		// ---------------
		// Handlers events
		// ---------------
		/**
		*
		*/
		onGetTerms: function (e) {
			this.getTerms();
		},

		/**
		*
		*/
		onGetEntity: function (e) {
			this.getEntity();
		},

		/**
		*
		*/
		onGetForm: function (e) {
			this.getForm();
		},

		// ----------------------------------------------------------//
		//-------------Get apply program steps content---------------//
		// ----------------------------------------------------------//
		/**
        * get results of mentoring questions
        */
        getTerms: function (triggerRoute) {

        	triggerRoute || (triggerRoute = false);

            app.AppRouter.navigate( Route.route('convocatoria.aplicar', {convocatoria: this.programModel.get('url_convocatoria'), step: 'terminos'}), {trigger: triggerRoute} );

            $(document).foundation('tab', 'toggle_active_tab', this.$('.get-apply-terms-program').parent());

            this.applyTermsView.render();
            // this.applyTermsView.trigger('getData');

            this.ready();
            this.parameters.step = 'terminos';
        },

        /**
        * get results of mentoring questions
        */
        getEntity: function (triggerRoute) {

        	triggerRoute || (triggerRoute = false);

            app.AppRouter.navigate( Route.route('convocatoria.aplicar', {convocatoria: this.programModel.get('url_convocatoria'), step: 'entidad'}), {trigger: triggerRoute} );

            $(document).foundation('tab', 'toggle_active_tab', this.$('.get-apply-entity-program').parent());

            switch( parseInt(this.programModel.get('codigo_orientacion_convocatoria')) ) {
            	case window._tp.orientationProgram['entity']: this.applyEntityView.render();
            		break;

            	case window._tp.orientationProgram['user']: this.applyUserView.render();
            		break;

            	default: return undefined;
            		break;
            }

            this.ready();
            this.parameters.step = 'entidad';
        },

        /**
        * get results of mentoring questions
        */
        getForm: function (triggerRoute) {
			
        	triggerRoute || (triggerRoute = false);

            app.AppRouter.navigate( Route.route('convocatoria.aplicar', {convocatoria: this.programModel.get('url_convocatoria'), step: 'formulario'}), {trigger: triggerRoute} );

            $(document).foundation('tab', 'toggle_active_tab', this.$('.get-apply-survey-program').parent());

            this.applyFormView.render();
            // this.applyFormView.trigger('getData');

            this.ready();
            this.parameters.step = 'formulario';
        }
	});

})(jQuery, this, this.document);
