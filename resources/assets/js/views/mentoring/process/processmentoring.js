/**
* Class ProcessMentoringList extends of Backbone View
* @author TuProyecto || Desarrollador : @cindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProcessMentoringList = Backbone.View.extend({
        el: '#mentoring-process-main',
        template: _.template( ($('#mentoring-process').html() || '') ),
        templateNotResultSessions: _.template( ($('#not-result-sessions-tpl').html() || '') ),
        templateNotResultMentoring: _.template( ($('#not-result-mentoring-tpl').html() || '') ),
        events: {
            'click .redirect___Mentoring': 'onRedirectMentoring',
        },
        parameters: {
        	'titleConfirm': ''
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
        	// extends attributtes
        	_.extend( this.parameters, opts.parameters );

			 // Extend options parameters
			if( _.isObject(opts.parameters) ){
				_.extend(this.parameters, opts.parameters);
			}


            // Initialize

            this.mentoringQuestionList = new app.MentoringQuestionList();

            // Initialize
            this.mentoringSessionList = new app.MentoringSessionList();

        	// Init Attributes

            this.listenTo( this.collection, 'reset', this.onReset ); // collectionSessions
            this.listenTo( this.collection, 'add', this.addOne );
            this.listenTo( this.collection, 'request', this.loadSpinner );
            this.listenTo( this.collection, 'sync', this.responseServer );

            this.listenTo( this.mentoringQuestionList, 'reset', this.onResetMentoring );
            this.listenTo( this.mentoringSessionList, 'reset', this.addAllSession );

            this.on('getData', this.getFirstData); // getDataSessions
            
            this.on('getDataMentoringAll', this.getFirstDataMentoringAll);

          

        },

        /*
        * Render View Element
        */
        render: function() {
            this.$el.html(this.template());

            this.$wrapperData = this.$('#mentoring-process-main');
            this.$wrapperSessions = this.$('#container-sessions-proccess');
            this.$wrapperMentoringPending = this.$('#container-mentoring-pending-proccess');
            this.$wrapperMentoringAll= this.$('#container-mentoring-all-proccess');

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
		},

        ready: function () {
			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
			}

			// reload plugins
			if( typeof(window.initComponent.select2Trigger) == 'function' && _.has($.fn, 'select2') )
				window.initComponent.select2Trigger();

			if( typeof(window.initComponent.chosenTrigger) == 'function' && _.has($.fn, 'chosen') )
				window.initComponent.chosenTrigger();

			if( typeof(window.initComponent.initConfigForm) == 'function' )
				window.initComponent.initConfigForm();
        },

        getFirstData: function(dataFilter, replace) {
            dataFilter || (dataFilter = {});
            replace || (replace = false);

            if(replace) {
                this.parameters.dataFilter = dataFilter;
            }else{
                _.extend( this.parameters.dataFilter, dataFilter );
            }

            this.parameters.dataFilter.state = window._tp.getState['pending'];
            this.collection.getFirstPage( {reset:true, data:_.clone(this.parameters.dataFilter)} );
            this.pageOld = this.collection.state.currentPage;
        },

        getFirstDataMentoringPending: function(dataFilter, replace) {
            dataFilter || (dataFilter = {});
            replace || (replace = false);

            if(replace) {
                this.parameters.dataFilter = dataFilter;
            }else{
                _.extend( this.parameters.dataFilter, dataFilter );
            }

            this.parameters.dataFilter.state = window._tp.getState['pending'];

            this.mentoringQuestionList.getFirstPage( {reset:true, data:_.clone(this.parameters.dataFilter)} );
            this.pageOld = this.mentoringQuestionList.state.currentPage;
        },

        getFirstDataMentoringAll: function(dataFilter, replace) {
            dataFilter || (dataFilter = {});
            replace || (replace = false);

            if(replace) {
                this.parameters.dataFilter = dataFilter;
            }else{
                _.extend( this.parameters.dataFilter, dataFilter );
            }

            this.parameters.dataFilter.state = '';

            this.mentoringQuestionList.getFirstPage( {reset:true, data:_.clone(this.parameters.dataFilter)} );
            this.pageOld = this.mentoringQuestionList.state.currentPage;
        },


        addOne: function(model) {

            var view = new app.MentoringItemSessionList({
                model: model,
                parameters: {
                    //
                }
            });

            this.$wrapperSessions.append( view.render().el );

            // refresh plugins
            this.ready();
        },

        onReset: function(collection) {

            this.$wrapperData.html('');

            if (this.collection.length > 0) {
                this.collection.forEach( this.addOne, this );
            } else {
                this.notResultSessions();
            }
        },

        notResultSessions: function() {
            this.$wrapperSessions.html(this.templateNotResultSessions());
        },

        addOneMentoring: function(model) {
            var attributes = model.toJSON();

            if (attributes.codigo_estado === window._tp.getState['active']) {
                var view = new app.MentoringQuestionItemView({
                    model: model,
                    parameters: {
                        template: ''
                    }
                });

                this.$wrapperMentoringAll.append( view.render().el );
            }


            if (attributes.codigo_estado === window._tp.getState['pending']) {
                var view = new app.MentoringQuestionItemView({
                    model: model,
                    parameters: {
                        template: 'templateMentoringPending'
                    }
                });

                this.$wrapperMentoringPending.append( view.render().el );
            }

            if (attributes.codigo_estado === window._tp.getState['closed']) {
                var view = new app.MentoringQuestionItemView({
                    model: model,
                    parameters: {
                        template: 'templateMentoringFinish'
                    }
                });

                this.$wrapperMentoringAll.append( view.render().el );
            }

            if (attributes.codigo_estado === window._tp.getState['finalized']) {
                var view = new app.MentoringQuestionItemView({
                    model: model,
                    parameters: {
                        template: 'templateMentoringFinish'
                    }
                });

                this.$wrapperMentoringAll.append( view.render().el );
            }

           if (attributes.codigo_estado === window._tp.getState['rejected']) {
                var view = new app.MentoringQuestionItemView({
                    model: model,
                    parameters: {
                        template: 'templateMentoringRejected'
                    }
                });

                this.$wrapperMentoringAll.append( view.render().el );
           }

            // refresh plugins
            this.ready();
        },

        onResetMentoring: function(collection) {

            this.$wrapperData.html('');

            if (this.mentoringQuestionList.length > 0) {
                this.mentoringQuestionList.forEach( this.addOneMentoring, this );
            } else {

                //this.notResultMentoring();
            }
        },

        notResultMentoring: function() {

            this.$wrapperMentoringPending.html(this.templateNotResultMentoring());
            this.$wrapperMentoringAll.html(this.templateNotResultMentoring());
        },

        addOneSession: function (mentoringModel) {

            var view = new app.MentoringItemSessionList({
                model: mentoringModel,
                parameters: {
                    //
                }
            });

            this.$wrapSessionMentoring.append( view.render().el );

            // refresh plugins
            this.ready();
        },

         /**
         * Render all view of Sessions
         */

        addAllSession: function() {
            this.$wrapperData.html('');
            this.mentoringSessionList.forEach( this.addOneSession, this );
        },

        onRedirectMentoring: function(e) {
            e.preventDefault();

            var mentoring = $(e.currentTarget).data('mentoring');

            // Redirect to Mentoring Content
            url = Route.route('mentoria.mentores.procesos.show', { procesos: mentoring }) ;
            Backbone.history.navigate(url, { trigger:true });
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
   });

})(jQuery, this, this.document);
