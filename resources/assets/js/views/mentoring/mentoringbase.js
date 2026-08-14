/**
* Class BaseMentoringView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.BaseMentoringView = Backbone.View.extend({

        el: '#mentoring-content',
        template: _.template( ($('#rol-switch-mentoring-tpl').html() || '') ),
        parameters: {
            tab: '',
            action: '',
            code_mentor: '',
            dataFilter: { }
        },

        /**
        * Constructor Method
        */
        initialize : function(opts){
            _.bindAll(this, 'beforeRender', 'render', 'afterRender',
                            'getCreateMentor');

            if( !_.isUndefined(opts) && _.isObject(opts.parameters) ){
                _.extend(this.parameters, opts.parameters);
            }

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Initialize attributes
            this.mentoringQuestionList = new app.MentoringQuestionList();
            this.mentoringSessionList = new app.MentoringSessionList();
            this.mentorList = new app.MentorList();
            this.mentorSessionModel = new app.MentoringSessionModel();

            this.mentoringProcessModel = new app.MentoringProcess();
            this.mentoringProcessList = new app.MentorignProcessList();
            
            // events listener
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );

        },

        /*
        * Render View Element
        */
        render: function () {
           
            var attributes =  {};
            attributes['tab'] = this.parameters['tab'];
            this.$el.html( this.template(attributes) );
            
            this.referenceToSections();

            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // code goes here
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {
            this.ready();

            // get section
            this.stuffTab( this.parameters.tab, this.parameters.action );
        },

        /**
        * fires libraries js
        */
        ready: function () {
            // trigger libraries
            if( _.has($.fn, 'foundation') ){
                $(document).foundation('tab', 'reflow');
            }
        },

        /**
        * reference to sections views mentoring
        */
        referenceToSections: function () {
            
            // Reference to view mentoring questions
            if ( this.mentoringQuestions instanceof Backbone.View ){
                this.mentoringQuestions.stopListening();
                this.mentoringQuestions.undelegateEvents();
                this.mentoringQuestions.remove();
            }

            this.mentoringQuestions = new app.MentoringQuestionListView({
                collection: this.mentoringQuestionList,
                parameters: {
                    dataFilter: _.extend({
                    }, this.parameters['dataFilter'])
                }
            });
        },

        /**
        * switch tabs mentoring
        */
        stuffTab: function ( tab, action ) {
            var _this = this,
                stuffTab = {
                    'mentores' : function() {
                        action || (action = 'mentores');

                        _this.stuffAction(action);
                    },
                    'preguntas' : function() {
                        action || (action = 'preguntas');

                        _this.stuffAction(action);
                    },
                    'sesiones' : function() {
                        action || (action = 'sesiones');

                        _this.stuffAction(action);
                    },
                    'disponibilidad' : function() {
                        action || (action = 'disponibilidad');

                        _this.stuffAction(action);
                    },
                    'mentor' : function() {
                        action || (action = 'mentor');

                        _this.stuffAction(action);
                    },
                    'crearpregunta' : function() {
                        action || (action = 'crearpregunta');

                        _this.stuffAction(action);
                    },
                    'process' : function() {
                        action || (action = 'process');
                        
                        _this.stuffAction(action);
                    },
                    'default': function () {
                        action || (action = 'mentor');

                        _this.stuffAction(action);
                    }
                };

            if (stuffTab[tab]) {
                stuffTab[tab]();
            } else {
                stuffTab['default']();
            }
        },

        /**
        * switch actions mentoring
        */
        stuffAction: function ( action ) {
            var _this = this,
                stuffAction = {
                    'mentores' : function() {
                        _this.getMentors();
                    },
                    'preguntas' : function() {
                        _this.getQuestions();
                    },
                    'sesiones' : function() {
                        _this.getSessions();
                    },
                    'process' : function() {
                        _this.getProcess();
                    },
                    'disponibilidad' : function() {
                        _this.getAvailability();
                    },
                    'mentor' : function() {
                        _this.getCreateMentor();
                    },
                    'crearpregunta' : function() {
                        _this.getCreateQuestions();
                    },
                    'default': function () {
                        //
                    }
                };

            if (stuffAction[action]) {
                stuffAction[action]();
            } else {
                stuffAction['default']();
            }
        },

        /**
        * get results of mentoring questions
        */
        getQuestions: function () {
            this.mentoringQuestions.render();
            this.mentoringQuestions.trigger('getData');
            this.mentoringQuestions.trigger('getDataSessions');
            this.mentoringQuestions.trigger('getDataMentoringActive');
        },

        /**
        * get results of mentoring sessions
        */
        getSessions: function () {
            //
        },

        /**
        * get mentor calendar availability
        */
        getAvailability: function () {
            // this.mentoringAvailability.render();
        },

        /**
        * get form create mentor
        */
        getCreateMentor: function () {

            this.userProfileModel = new app.UserModel();
            this.userProfileModel.url = function () {
				return window.Misc.urlFull( Route.route('usuario.auth') );
			};

            if ( this.mentorProfileView instanceof Backbone.View ){
                this.mentorProfileView.stopListening();
                this.mentorProfileView.undelegateEvents();
            }

            this.mentorProfileView = new app.MentoringCreateMentorView({ model: this.userProfileModel });
            this.userProfileModel.fetch();
        },

        /**
        * get form create question
        */
        getCreateQuestions: function () {

            this.mentorProfileModel = new app.UserModel();
            this.mentorProfileModel.idAttribute = 'nickname_usuario';
            this.mentorProfileModel.set({'nickname_usuario': this.parameters.dataFilter['nickname']});

            // Reference to view requestMentoring
			if ( this.requestMentoring instanceof Backbone.View ){
				this.requestMentoring.stopListening();
				this.requestMentoring.undelegateEvents();
				this.requestMentoring.remove();
			}

			this.requestMentoring = new app.RequestMentoringView({
				model: this.mentorProfileModel,
				parameters: {
				   //
				}
            });
            this.mentorProfileModel.fetch();
        },

        /**
        * get list Mentors
        */
        getMentors: function () {
            
             // Reference to view list mentors
            if ( this.mentorListView instanceof Backbone.View ){
                this.mentorListView.stopListening();
                this.mentorListView.undelegateEvents();
                this.mentorListView.remove();
            }

            this.mentorListView = new app.MentorListView({
                collection: this.mentorList,
                parameters: {
                    dataFilter: _.extend({
                    }, this.parameters['dataFilter'])
                }
            });

            this.mentorListView.render();
            this.mentorListView.trigger('getData');
        },

        getProcess: function(){

            if ( this.mentoringProccessView instanceof Backbone.View ){
                this.mentoringProccessView.stopListening();
                this.mentoringProccessView.undelegateEvents();
                this.mentoringProccessView.remove();
            }

            // Reference to view proccess
            this.mentoringProccessView = new app.ProcessMentoringList({
                collection: this.mentoringSessionList,
                parameters: {
                    dataFilter: _.extend({
                    }, this.parameters['dataFilter'])
                }
            });

            this.mentoringProccessView.render();
            this.mentoringProccessView.trigger('getData');
            this.mentoringProccessView.trigger('getDataMentoringAll');
        }

    });
})(jQuery, this, this.document);
