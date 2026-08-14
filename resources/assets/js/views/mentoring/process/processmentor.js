/**
* Class ProcessMentor extends of Backbone View
* @author TuProyecto || Desarrollador : @rfigueredo
* @link http://TuProyecto.com
*/


//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.ProcessMentor = Backbone.View.extend({

        el: '#mentoring-content',
        template: _.template( ($('#mentoring-feedback-tpl').html() || '') ),
        templateAttachedMentoring: _.template( ($('#attached-mentoring-tpl').html() || '') ),
        templateDiscusionMentoring: _.template( ($('#discusion-mentoring-tpl').html() || '') ),
        templateDevelopmentSession: _.template( ($('#form-session-development').html() || '') ),
        templateButtonAcceptSession: _.template( ($('#buttonAcceptMentoring-tpl').html() || '') ),
        templateTitleSession: _.template( ($('#title-session-tpl').html() || '') ),
        templateSessionProcessList: _.template( ($('#mentoring-sessions-process-list-tpl').html() || '') ),
        templateTaskItem: _.template( ($('#mentoring-task-session-item-tpl').html() || '') ),
        templateTagsItem: _.template( ($('#mentoring-tags-session-item-tpl').html() || '') ),
        templateSessionContent: _.template( ($('#session-content-tpl').html() || '') ),
        templateNotResultSessions: _.template( ($('#not-result-sessions-calendar-tpl').html() || '') ),
        templateSessionList: _.template( ($('#options-session-list-item').html() || '') ),
        events: {
            'click .modify__Session': 'onModifySession',
            'click .modify__Session_Finished': 'onModifySessionFinished',
            'click .cancel__Session': 'onCancelSesion',
            'click .back__Tosession': 'onBackSession',
            'click .conclude__Mentoring' : 'onConclude',
            'click .accept__Mentoring': 'onAccept',
            'click .refuse__Mentoring': 'onRefuse',
            'click .cancel__Mentoring': 'onRefuse',
            'click .add-mentoring-task-session': 'onAddTask',
            'click .add-mentoring-description-session': 'onAddDescription',
            'keypress #mentoring-task-session': 'onAddTask',
            'click .remove-mentoring-task-session': 'onRemoveTask',
            'click .remove-mentoring-tags-session': 'onRemoveTags',
            'click .add-mentoring-tags-session': 'onAddTag',
            'keypress #mentoring-tags-title': 'onAddTag',
            'click .add-mentoring-objetive-general-session': 'onAddGeneralObjetive',
            'click #button-accept-mentoring': 'onAcceptProccessMentoring',
            'click .add-mentoring-duration-session': 'onAddDuration',
            'click .add-mentoring-phase-session': 'onAddPhase',
            'click .add-mentoring-recommends-session': 'onAddRecommends',
            'click .add-mentoring-tracing-session': 'onAddTracing',
            'submit #add-mentoring-assigvoucher-session': 'onAddAssigVoucher',
            'click .add-mentoring-diagnosis-session': 'onAddDiagnosis',
            'change #mentoring-phase' : 'onAddDiagnosisChange',

        },
        parameters: {
        	//
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
        	// extends attributtes
            _.extend( this.parameters, opts.parameters );
            _.bindAll(this, 'beforeRender', 'render', 'afterRender',
            'onBackSession', 'addAllSession', 'addOneSession', 'onCancelSesion',
            'responseItemDelete', 'responseServer', 'loadSpinner');



        	//Init Attributes
            this.configAlert = {
                'wrapper': '#mentoring-wrapper',
                'closeTime': 4000,
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

            this.confCollection = { reset: true, data: {} };

            this.$wrapperData = this.$('.body-session-content');
            this.listTaskWrapper = this.$('.body-session-content').find('#mentoring-task-session-list');
            this.listTagsWrapper = this.$('.body-session-content').find('#mentoring-tags-session-list');
            this.$noResults = this.$('.no-results-filter');
            this.discussionList = new app.DiscussionList();

            this.mentoringSessionList = new app.MentoringSessionList();

            this.mentoringTaskList = new app.MentoringTaskList();

            this.mentoringTagsList = new app.MentoringTagsList();

            this.mentoringSessionModel =   new app.MentoringModel;

            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            // this.listenTo( this.mentoringSessionList, 'change:finished', this.render2 );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.mentoringSessionList, 'add', this.addOneSession );
            this.listenTo( this.mentoringSessionList, 'reset', this.addAllSession );
            this.listenTo( this.mentoringSessionList, 'request', this.loadSpinner );
            this.listenTo( this.mentoringSessionList, 'sync', this.responseServer );
            this.listenTo( this.mentoringSessionList, 'remove', this.responseItemDelete );
            this.listenTo( this.mentoringTaskList, 'add', this.addOneTask );
            this.listenTo( this.mentoringTaskList, 'reset', this.addAllTask );
            this.listenTo( this.mentoringTaskList, 'request', this.loadSpinner );
            this.listenTo( this.mentoringTaskList, 'sync', this.responseServer );
            this.listenTo( this.mentoringTaskList, 'remove', this.responseItemDelete );
            this.listenTo( this.mentoringTagsList, 'add', this.addOneTags );
            this.listenTo( this.mentoringTagsList, 'reset', this.addAllTags );
            this.listenTo( this.mentoringTagsList, 'request', this.loadSpinner );
            this.listenTo( this.mentoringTagsList, 'sync', this.responseServer );
            this.listenTo( this.mentoringTagsList, 'remove', this.responseItemDelete );
        },

       /*
        * Render View Element
        */
       render: function() {
        var attributes = {};
        var attributes = this.model.toJSON();
        attributes.finished = false;
        attributes.estado_session = null;

        this.$wrapperRenderSession = this.$('#mentoring-session');

        this.$wrapperRenderSession.html( this.template(attributes) );
        this.$wrapperBodySesion = this.$('.body-session-content');

        // Render attach mentoring
        this.$('#attachedMentoring').html(this.templateAttachedMentoring(attributes));

        // Render discusion mentoring
        this.$('#discusionMentoring').html(this.templateDiscusionMentoring(attributes));

        this.mentoringSessionList.fetch({reset:true, data: { advisory: attributes.codigo_asesoria }});


        this.referenceView();
    },


        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            //
        this.mentoringSessionList.fetch({reset:true, data: { advisory: attributes.codigo_asesoria }});

        },

        /**
        * Fires before of run render function
        */
        afterRender: function () {
            var _this = this;

            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }
        },

        referenceView: function() {
             // Reference to view mentoring sessions
            if ( this.mentoringSessions instanceof Backbone.View ){
                this.mentoringSessions.stopListening();
                this.mentoringSessions.undelegateEvents();
                this.mentoringSessions.remove();
            }

            // Reference of Discucion Component
            if ( this.discussionListView instanceof Backbone.View ){
                this.discussionListView.stopListening();
                this.discussionListView.undelegateEvents();
                this.discussionListView.remove();
            }

            // Reference of Documents
            if ( this.mentoringQuestionDocuments instanceof Backbone.View ){
                this.mentoringQuestionDocuments.stopListening();
                this.mentoringQuestionDocuments.undelegateEvents();
                this.mentoringQuestionDocuments.remove();
            }


            // Instance of Discucion component
            this.discussionListView = new app.DiscussionListView({
                collection: this.discussionList,
                parameters: {
                    'formDiscussion': '#form-discussion-advice',
                    dataFilter: {
                        'codigo_recurso_modulo': this.model.get('codigo_mentoria'),
                        'codigo_modulo': window._tp.getModule('mentoring')
                    }
                }
            });

            // Instance of Documents of Advice
            this.mentoringQuestionDocuments = new app.MentoringQuestionDocuments({
                el: this.$wrapperRenderSession.find('#wrap-documents'),
                model: this.model,
                parameters: {
                    //
                }
            });

            this.mentoringQuestionDocuments.render();

        },

        noResultsAttached: function() {
            var attributes = this.model.toJSON();

            this.$wrapperRenderSession.find('#wrap-documents').html( this.templateNotResultSessions(attributes) );
        },

        onConclude: function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            console.log("onConclude");
            var _this = this,
                data = {
                    action: 'conclude'
                };

            this.acceptSendConfirm = new app.ConfirmWindow({
                model: _this.model,
                parameters: {
                    template: _.template($("#mentoring-end-confirm-tpl").html() || ""),
                    titleConfirm: "¿ Está seguro de finalizar la asesoría/mentoría ?",
                    onConfirm: function () {
                        _this.model.save(data, {patch: true, wait: true,
                            success: function (model, resp) {
                                // response success or error
                                var text = resp.success ? resp.message : resp.errors,
                                    type = resp.success ? 'success' : 'alert';

                                if( _.isObject(resp.errors) ){

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
                                _.extend( _this.configAlert, config );

                                Backbone.history.navigate(Route.route('mentoria.preguntas.evaluacion.mentor.create', {
                                    user: model.get('codigo_asesoria') } ), { trigger:true });
                            }
                        });
                    }
                }
            });

            this.acceptSendConfirm.render();
        },

        onAccept: function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var _this = this,
                data = {
                    action: 'accept'
                };

            this.acceptSendConfirm = new app.ConfirmWindow({
                model: _this.model,
                parameters: {
                    template: _.template($("#mentoring-accept-confirm-tpl").html() || ""),
                    titleConfirm: "¿ Está seguro de aceptar la mentoría ?",
                    onConfirm: function () {
                        _this.model.save(data, {patch: true, wait: true,
                            success: function (model, resp) {
                                // response success or error
                                var text = resp.success ? resp.message : resp.errors,
                                    type = resp.success ? 'success' : 'alert';

                                if( _.isObject(resp.errors) ){

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
                                _.extend( _this.configAlert, config );

                                Backbone.history.loadUrl();
                            }
                        });
                    }
                }
            });

            this.acceptSendConfirm.render();
        },

        onRefuse: function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var _this = this,
                data = {
                    action: 'refuse'
                };

            this.acceptSendConfirm = new app.ConfirmWindow({
                model: _this.model,
                parameters: {
                    template: _.template($("#mentoring-refuse-confirm-tpl").html() || ""),
                    titleConfirm: "¿ Está seguro de rechazar la mentoría ?",
                    onConfirm: function () {
                        _this.model.save(data, {patch: true, wait: true,
                            success: function (model, resp) {
                                // response success or error
                                var text = resp.success ? resp.message : resp.errors,
                                    type = resp.success ? 'success' : 'alert';

                                if( _.isObject(resp.errors) ){

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
                                _.extend( _this.configAlert, config );

                                Backbone.history.loadUrl();
                            }
                        });
                    }
                }
            });

            this.acceptSendConfirm.render();
        },

        onCancel: function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var _this = this,
                data = {
                    action: 'refuse'
                };

            this.acceptSendConfirm = new app.ConfirmWindow({
                model: _this.model,
                parameters: {
                    template: _.template($("#mentoring-refuse-confirm-tpl").html() || ""),
                    titleConfirm: "¿ Está seguro de rechazar la mentoría ?",
                    onConfirm: function () {
                        _this.model.save(data, {patch: true, wait: true,
                            success: function (model, resp) {
                                // response success or error
                                var text = resp.success ? resp.message : resp.errors,
                                    type = resp.success ? 'success' : 'alert';

                                if( _.isObject(resp.errors) ){

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
                                _.extend( _this.configAlert, config );

                                Backbone.history.navigate(Route.route('mentoria.preguntas.index') );
                            }
                        });
                    }
                }
            });

            this.acceptSendConfirm.render();
        },

        addOneSession: function (mentoringModel) {

            if ( view instanceof Backbone.View ){
                view.stopListening();
                view.undelegateEvents();
                view.remove();
            }

            var view = new app.MentoringSessionListItemView({
                model: mentoringModel,
                parameters: {
                    //rol: this.parameters['rol']
                }
            });
            this.$('.body-session-content').append( view.render().el );
        },

        addOneTask: function (taskModel) {
            var attributes = taskModel.toJSON();
            attributes.finished = this.mentoringSessionModel.get('finished');
            attributes.estado = this.mentoringSessionModel.get('estado');

            this.listTaksWrapper = this.$('.body-session-content').find('#mentoring-task-session-list');
            this.listTaksWrapper.append(this.templateTaskItem(attributes));

        },

        addOneTags: function (tagsModel) {
            var attributes = tagsModel.toJSON();
            attributes.finished = this.mentoringSessionModel.get('finished');
            attributes.estado = this.mentoringSessionModel.get('estado');

            this.listTagsWrapper = this.$('.body-session-content').find('#mentoring-tags-session-list');
            this.listTagsWrapper.append(this.templateTagsItem(attributes));

        },

        onModifySession: function(e) {
            e.preventDefault();
            e.stopPropagation();
            _this = this;
            this.mentoringTaskList.reset();
            this.mentoringTagsList.reset();
            this.listTaskWrapper.html("");
            this.listTagsWrapper.html("");
            var id = $(e.target).data('id') || null, finished = $(e.target).data('finished');
            this.mentoringSessionModel.clear({silent:true});
            this.mentoringSessionModel = this.mentoringSessionList.findWhere({id_mentoria: id});

            var attributes = typeof this.mentoringSessionModel !== 'undefined' ? this.mentoringSessionModel.toJSON() : {};
            attributes.finished = finished;
            attributes.estado = this.mentoringSessionModel.get('estado');

            var modelAttributes = this.model.toJSON();
            modelAttributes.finished = finished;
            modelAttributes.estado_session = this.mentoringSessionModel.get('estado');
            modelAttributes.mentoring = this.mentoringSessionModel.get('codigo_mentoria');

            // Set parameter in Models
            this.mentoringSessionModel.set({finished: finished});

            /* if was passed mentoring code */
            if( !_.isUndefined(attributes.codigo_mentoria) && !_.isNull(attributes.codigo_mentoria) )
            {
                this.confCollection.data.codigo_mentoria = attributes.codigo_mentoria;
                this.mentoringTaskList.fetch( this.confCollection,{success: function(model, response) {
                    attributes.tareas = _this.mentoringTaskList.toJSON();
                    _this.$('.body-session-content').html(_this.templateDevelopmentSession(attributes));
                    _this.$el.find('.title-session').html(_this.templateTitleSession({ list: true }));
                } } );
                this.mentoringTagsList.fetch(this.confCollection, { success: function(model, response) {
                    attributes.tags = _this.mentoringTagsList.toJSON();
                } });

            }

            this.$('#buttonAcceptMentoring').html(this.templateButtonAcceptSession(attributes));
            this.$('.body-session-content').html(this.templateDevelopmentSession(attributes));
            this.$el.find('.title-session').html(this.templateTitleSession({ list: true }));

            // Render other components
            this.$('#attachedMentoring').html(this.templateAttachedMentoring(modelAttributes));
            this.$('#discusionMentoring').html(this.templateDiscusionMentoring(modelAttributes));

            this.referenceView();
        },

        /**
         * Mentoring Fisnished Session
         */
        onModifySessionFinished: function(e) {
            e.preventDefault();
            e.stopPropagation();
            _this = this;
            this.mentoringTaskList.reset();
            this.mentoringTagsList.reset();
            this.listTaskWrapper.html("");
            this.listTagsWrapper.html("");
            var id = $(e.target).data('id') || null, finished = $(e.target).data('finished');
            this.mentoringSessionModel.clear({silent:true});
            this.mentoringSessionModel = this.mentoringSessionList.findWhere({id_mentoria: id});

            var attributes = typeof this.mentoringSessionModel !== 'undefined' ? this.mentoringSessionModel.toJSON() : {};
            attributes.finished = finished;

            var modelAttributes = this.model.toJSON();
            modelAttributes.finished = finished;

            var data = {
                'mentoria': this.mentoringSessionModel.get('codigo_mentoria'),
                'asesoria': modelAttributes.codigo_asesoria
            }

            // Method POST to change state of Mentoring
            $.post(document.url + Route.route('mentoria.sesiones.finalizar'), data, function(resp) {
                var text = resp.success ? resp.message : resp.errors,
                type = resp.success ? 'success' : 'alert';

                if( _.isObject(resp.errors) ){

                    var listError = '<ul>';

                    $.each(resp.errors, function(field, item) {
                        listError += '<li>'+ item[0] +'</li>';
                    });
                    listError += '</ul>';

                    text = listError;
                }
            });

            // Set parameter in Model
            this.mentoringSessionModel.set({finished: finished});

            /* if was passed mentoring code */
            if( !_.isUndefined(attributes.codigo_mentoria) && !_.isNull(attributes.codigo_mentoria) )
            {
                this.confCollection.data.codigo_mentoria = attributes.codigo_mentoria;
                this.mentoringTaskList.fetch( this.confCollection,{success: function(model, response) {
                    attributes.tareas = _this.mentoringTaskList.toJSON();
                    _this.$('.body-session-content').html(_this.templateDevelopmentSession(attributes));
                    _this.$el.find('.title-session').html(_this.templateTitleSession({ list: true }));
                } } );
                this.mentoringTagsList.fetch(this.confCollection, { success: function(model, response) {
                    attributes.tags = _this.mentoringTagsList.toJSON();
                } });

            }

            this.$('.body-session-content').html(this.templateDevelopmentSession(attributes));
            this.$el.find('.title-session').html(this.templateTitleSession({ list: true }));

            // Render other components
            this.$('#attachedMentoring').html(this.templateAttachedMentoring(modelAttributes));
            this.$('#discusionMentoring').html(this.templateDiscusionMentoring(modelAttributes));

            //to refresh view
            app.AppRouter.navigate( Route.route('mentoria.mentores.procesos.show', {'procesos': this.model.get('codigo_asesoria') }), {trigger: true, replace: true} );


            // this.referenceView();
        },

        /**
         * Accept Mentoring Process
         */

        onAcceptProccessMentoring: function(e) {
            e.preventDefault();
            e.stopPropagation();
            _this = this;
            this.mentoringTaskList.reset();
            this.mentoringTagsList.reset();
            this.listTaskWrapper.html("");
            this.listTagsWrapper.html("");
            var id = $(e.target).data('id') || null, finished = $(e.target).data('finished');
            var mentoring = $(e.currentTarget).data('mentoring');
            this.mentoringSessionModel.clear({silent:true});
            this.mentoringSessionModel = this.mentoringSessionList.findWhere({id_mentoria: id});

            var attributes = typeof this.mentoringSessionModel !== 'undefined' ? this.mentoringSessionModel.toJSON() : {};
            attributes.finished = finished;

            var modelAttributes = this.model.toJSON();
            modelAttributes.finished = finished;

            var data = {
                'mentoria': mentoring,
                'accept': true,
                'asesoria': modelAttributes.codigo_asesoria
            }

            // Method POST to change state of Mentoring
            $.post(document.url + Route.route('mentoria.sesiones.finalizar'), data, function(resp) {
                var text = resp.success ? resp.message : resp.errors,
                type = resp.success ? 'success' : 'alert';

                if( resp.success ){
                    window.location.reload();
                }

                if( _.isObject(resp.errors) ){

                    var listError = '<ul>';

                    $.each(resp.errors, function(field, item) {
                        listError += '<li>'+ item[0] +'</li>';
                    });
                    listError += '</ul>';

                    text = listError;
                }
            });
        },

        /**
        * destroy Mentoring
        */
        onCancelSesion: function (e) {

            e.preventDefault();
            e.stopPropagation();
            var id = $(e.currentTarget).data('id') || null;
            this.mentoringSessionModel.clear({silent:true});
            this.mentoringSessionModel = this.mentoringSessionList.findWhere({id_mentoria: id});

            if(typeof this.mentoringSessionModel !== 'undefined' &&  this.mentoringSessionModel instanceof Backbone.Model )
            {
                this.confirmRemove = new app.ConfirmRemoveProcessMentoringView({
                    model:   this.mentoringSessionModel ,
                    parameters: {
                    'titleConfirm' : '¿Estás seguro que quieres cancelar esta mentoría?'
                    }
                });

                this.confirmRemove.render();
                this.mentoringSessionList.reset(this.mentoringSessionList.toJSON());

            }

        },

        onBackSession: function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            this.$('#buttonAcceptMentoring').html("");
            this.$('.body-session-content').html("");
            this.$el.find('.title-session').html(this.templateTitleSession({ list: false }));
            this.mentoringSessionList.reset(this.mentoringSessionList.toJSON());

            var modelAttributes = this.model.toJSON();
            modelAttributes.finished = false;
            modelAttributes.estado_session = null;

            // Render other components
            this.$('#attachedMentoring').html(this.templateAttachedMentoring(modelAttributes));
            this.$('#discusionMentoring').html(this.templateDiscusionMentoring(modelAttributes));

            this.referenceView();
        },

        /**
         * Render all view of Sessions
         */

        addAllSession: function() {
            //this.$wrapperData.html('');
            this.$('.body-session-content').html('');
            this.mentoringSessionList.forEach( this.addOneSession, this );
            this.$el.find('.title-session').html(this.templateTitleSession({ list: false }));
        },

        /**
         * Render all view of Sessions
         */

        addAllTask: function() {
            this.listTaskWrapper.html("");
            this.mentoringTaskList.forEach( this.addOneTask, this );

        },

        /**
         * Render all view of Sessions
         */

         addAllTags: function() {
            this.listTagsWrapper.html("");
            this.mentoringTagsList.forEach( this.addOneTags, this );

        },

        /**
        * add a new target to the adviser schedule
        */
        onAddTask: function (e) {

        var codeKey = e.keyCode || e.which;
        var _this = this;
            if( e.type == 'keypress' ){
                if( codeKey !== 13 )
                    return;
            }else{
                e.preventDefault();
                e.stopImmediatePropagation();
            }

            this.listTaskWrapper = this.$('.body-session-content').find('#mentoring-task-session-list');
            var $fieldTaskInput =  this.$('.body-session-content').find('#mentoring-task-session');

            var fieldTask = $fieldTaskInput.val() || '';
                fieldTask = fieldTask.trim();

            if( fieldTask.length ){


                var taskModel = new app.MentoringTaskModel({
                    descripcion_tarea_mentoria: fieldTask,
                    codigo_mentoria: this.mentoringSessionModel.get('codigo_mentoria')
                });

                window.Misc.setSpinner( this.$el );

                taskModel.save({
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content')}
                },{success: function(model, resp) {

                    window.Misc.removeSpinner({
                        'wrap': _this.$el,
                        'direct': false
                    });

                    _this.mentoringTaskList.reset(_this.mentoringTaskList.toJSON());

                    var text = resp.success ? resp.message : resp.errors,
                                    type = resp.success ? 'success' : 'alert';

                                if( _.isObject(resp.errors) ){

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
                                _.extend( _this.configAlert, config );

                    if( resp.success ){

                        _this.mentoringTaskList.add(model);
                        $fieldTaskInput.val('');

                    }else{
                        window.Misc.showAlertBox( _this.configAlert );
                    }




                }});

            }



            if( codeKey === 13 ) return false;
    },

    onAddDescription: function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var $fieldDescriptionMentoring =  this.$('.body-session-content').find('#mentoring-description');
        var fieldDescriptionMentoring = $fieldDescriptionMentoring.val() || '',
        fieldDescriptionMentoring = fieldDescriptionMentoring.trim();
        var data = {
            'description': fieldDescriptionMentoring,
            'mentoria': this.mentoringSessionModel.get('codigo_mentoria')
        }
        var _this = this;
        $.post(document.url + Route.route('mentoria.sesiones.descripcion'), data, function(resp) {
            window.Misc.setSpinner( this.$el );

            // console.log('mentorin ', _this.mentoringSessionModel)
            _this.mentoringSessionModel.set({description: fieldDescriptionMentoring})

            var text = resp.success ? resp.message : resp.errors,
            type = resp.success ? 'success' : 'alert';

            if( _.isObject(resp.errors) ){

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
            _.extend( _this.configAlert, config );

            window.Misc.showAlertBox( _this.configAlert );
        });
    },

    /**
     * guarda fase del proceso, campo de rutan
     * @param {event} e 
     */
    onAddPhase: function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var $fieldPhaseMentoring =  this.$('.body-session-content').find('#mentoring-phase');
        var fieldPhaseMentoring = $fieldPhaseMentoring.val(),
            fieldPhaseMentoring = fieldPhaseMentoring.trim();

        var data = {
            'phase': fieldPhaseMentoring,
            'mentoria': this.mentoringSessionModel.get('codigo_mentoria')
        }

        var route = 'mentoria.sesiones.phase';

        this.onRequest(data, route, {phase: fieldPhaseMentoring});

    },

    /**
     * guarda pregunta : ¿Se recomienda para la siguiente etapa?, campo de rutan
     * @param {event} e 
     */
    onAddRecommends: function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var $fieldRecommendsMentoring =  this.$('.body-session-content').find('#mentoring-recommends');
        var fieldRecommendsMentoring = $fieldRecommendsMentoring.val(),
            fieldRecommendsMentoring = fieldRecommendsMentoring.trim();

        var data = {
            'recommends': fieldRecommendsMentoring,
            'mentoria': this.mentoringSessionModel.get('codigo_mentoria')
        }

        var route = 'mentoria.sesiones.recommends';

        this.onRequest(data, route, {recommends: fieldRecommendsMentoring});

    },

    /**
     * guarda pregunta : Seguimiento, campo de rutan
     * @param {event} e 
     */
    onAddTracing: function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var $fieldTracingMentoring =  this.$('.body-session-content').find('#mentoring-tracing');
        var fieldTracingMentoring = $fieldTracingMentoring.val(),
            fieldTracingMentoring = fieldTracingMentoring.trim();

        var data = {
            'tracing': fieldTracingMentoring,
            'mentoria': this.mentoringSessionModel.get('codigo_mentoria')
        }

        var route = 'mentoria.sesiones.tracing';

        this.onRequest(data, route, {tracing: fieldTracingMentoring});

    },

    /**
     * guarda pregunta : asignacion de voucher, campo de rutan
     * @param {event} e 
     */
    onAddAssigVoucher: function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var datacheckbox = window.Misc.formToJson( e.target );

        var data = {
            'assigvoucher': datacheckbox,
            'mentoria': this.mentoringSessionModel.get('codigo_mentoria')
        }

        var route = 'mentoria.sesiones.assigvoucher';

        this.onRequest(data, route, {assigvoucher: datacheckbox});

    },

    onAddDiagnosisChange: function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var $fieldPhaseMentoring =  this.$('.body-session-content').find('#mentoring-phase');
        var fieldPhaseMentoring = $fieldPhaseMentoring.val(),
            fieldPhaseMentoring = fieldPhaseMentoring.trim();

        //si la fase es 'diagnostico' muestra campo Diagnostico
        if (fieldPhaseMentoring === 'diagnóstico') {
            $('#field-diagnosis').css("display", "block");
        } else {
            $('#field-diagnosis').css("display", "none");
        }
    },

    /**
     * guarda pregunta : Diagnóstico, campo de rutan
     * @param {event} e
     */
    onAddDiagnosis: function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var $fieldDiagnosisMentoring =  this.$('.body-session-content').find('#mentoring-diagnosis');
        var fieldDiagnosisMentoring = $fieldDiagnosisMentoring.val(),
            fieldDiagnosisMentoring = fieldDiagnosisMentoring.trim();

        var data = {
            'diagnosis': fieldDiagnosisMentoring,
            'mentoria': this.mentoringSessionModel.get('codigo_mentoria')
        }

        var route = 'mentoria.sesiones.diagnosis';

        this.onRequest(data, route, {diagnosis: fieldDiagnosisMentoring});

    },

    /**
     * se encarga se hacer la solicitud al controlador
     * @param {object} data datos para enviar en la solicitud
     * @param {string} route ruta que atienda la solicitud
     * @param {object} fielObject para actualizar datos del campo
     * @return {void} void
     */
    onRequest: function (data, route, fielObject) {
        var _this = this;
        window.Misc.setSpinner( $('.body-session-content') );

        $.post(document.url + Route.route(route), data, function(resp) {
                _this.mentoringSessionModel.set(fielObject)

            var text = resp.success ? resp.message : resp.errors,
                type = resp.success ? 'success' : 'alert';

            window.Misc.removeSpinner({
                'wrap': $('.body-session-content'),
                'direct': false
            });

            if( _.isObject(resp.errors) ){

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
            _.extend( _this.configAlert, config );

            window.Misc.showAlertBox( _this.configAlert );
        })
        .error (function ( XMLHttpRequest, textStatus, errorThrown ) {
            const text = 'Contacte con el administrador';
            const type = 'alert';

            var config = {
                'text': text,
                'type': type
            };

            _.extend( _this.configAlert, config );

            window.Misc.showAlertBox( _this.configAlert );
        });
    },

    onAddDuration: function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var $fieldDurationHourMentoring =  this.$('.body-session-content').find('#mentoring-duration-hour-value');
        var fieldDurationHourMentoring = $fieldDurationHourMentoring.val() || '',
        fieldDurationHourMentoring = fieldDurationHourMentoring.trim();

        var $fieldDurationMinutesMentoring =  this.$('.body-session-content').find('#mentoring-duration-minutes-value');
        var fieldDurationMinutesMentoring = $fieldDurationMinutesMentoring.val() || '',
        fieldDurationMinutesMentoring = fieldDurationMinutesMentoring.trim();
        var data = {
            'hour': fieldDurationHourMentoring,
            'minutes': fieldDurationMinutesMentoring,
            'mentoria': this.mentoringSessionModel.get('codigo_mentoria')
        }
        var _this = this;
        $.post(document.url + Route.route('mentoria.sesiones.duration'), data, function(resp) {
           // window.Misc.setSpinner( this.$el );

            // console.log('mentorin ', _this.mentoringSessionModel)
            /*_this.mentoringSessionModel.set({
                    hour: fieldDurationHourMentoring,
                    minutes: fieldDurationMinutesMentoring,
                })*/

            const text = resp.success ? resp.message : resp.errors;
            const type = resp.success ? 'success' : 'alert';

            var config = {
                'text': text,
                'type': type
            };

            _.extend( _this.configAlert, config );

            window.Misc.showAlertBox( _this.configAlert );

        })
    },

    /**
    * add a new target to the adviser schedule
    */
    onRemoveTask: function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var id = $(e.currentTarget).data('id') || null;
            var li =   $(e.target).parents('li');

            var taskModel = this.mentoringTaskList.findWhere({item: id});

            if(typeof taskModel !== 'undefined' &&  taskModel instanceof Backbone.Model )
            {
                console.log('TaskModel', taskModel.toJSON());
                taskModel.destroy({
                    processData: true,
                    wait: true,
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'codigo_tarea_mentoria': taskModel.get('codigo_tarea_mentoria')
                    },
                    success: function(model, resp) {
                            console.log('sucess', resp);
                            _this.mentoringTaskList.reset(_this.mentoringTaskList.toJSON());

                            var text = resp.success ? resp.message : resp.errors,
                                            type = resp.success ? 'success' : 'alert';

                                        if( _.isObject(resp.errors) ){

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
                                        _.extend( _this.configAlert, config );

                                        window.Misc.removeSpinner({
                                            'wrap': _this.$el,
                                            'direct': false
                                        });

                            if( resp.success ){
                                li.remove();
                            }else{
                                window.Misc.showAlertBox( _this.configAlert );
                            }
                    },
                    error: function (model, resp) {
                        console.log('errorResp!',resp );
                        window.Misc.removeSpinner({
                            'wrap': _this.$el,
                            'direct': false
                        });

                        _this.mentoringTaskList.reset(_this.mentoringTaskList.toJSON());

                        var text = resp.errors ? resp.errors : '' ,
                            type =  'alert';

                        if( _.isObject(resp.errors) ){

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
                        _.extend( _this.configAlert, config );

                        window.Misc.showAlertBox( _this.configAlert );
                    }});

            } else {
                    li.remove();
            }
    },

    onRemoveTags: function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var id = $(e.currentTarget).data('id') || null;
        var li =   $(e.target).parents('li');

        var tagsModel = this.mentoringTagsList.findWhere({item: id});

        if(typeof tagsModel !== 'undefined' &&  tagsModel instanceof Backbone.Model )
        {
            console.log('TagsModel', tagsModel);
            tagsModel.destroy({
                processData: true,
                wait: true,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'codigo_tags_mentoria': tagsModel.get('codigo_tag_sesion_mentoria')
                },
                success: function(model, resp) {
                    console.log('sucess', resp);
                    _this.mentoringTagsList.reset(_this.mentoringTagsList.toJSON());

                    var text = resp.success ? resp.message : resp.errors,
                        type = resp.success ? 'success' : 'alert';

                    if( _.isObject(resp.errors) ){

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
                    _.extend( _this.configAlert, config );

                    window.Misc.removeSpinner({
                        'wrap': _this.$el,
                        'direct': false
                    });

                    if( resp.success ){
                        li.remove();
                    }else{
                        window.Misc.showAlertBox( _this.configAlert );
                    }
                },
                error: function (model, resp) {
                    console.log('errorResp!',resp );
                    window.Misc.removeSpinner({
                        'wrap': _this.$el,
                        'direct': false
                    });

                    _this.mentoringTagsList.reset(_this.mentoringTagsList.toJSON());

                    var text = resp.errors ? resp.errors : '' ,
                        type =  'alert';

                    if( _.isObject(resp.errors) ){

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
                    _.extend( _this.configAlert, config );

                    window.Misc.showAlertBox( _this.configAlert );
            }});

        } else {
            li.remove();
        }
    },

    /**
    ** Add logic to Add Task Mentoring
    */
    onAddTag: function (e) {
        var codeKey = e.keyCode || e.which;
        var _this = this;
        if( e.type == 'keypress' ){
            if( codeKey !== 13 )
                return;
        }else{
            e.preventDefault();
            e.stopImmediatePropagation();
        }

        this.listTagWrapper = this.$('.body-session-content').find('#mentoring-tags-list');
        var $fieldTagTitleInput =  this.$('.body-session-content').find('#mentoring-tags-title'),
            $fieldTagValueInput = this.$('.body-session-content').find('#mentoring-tags-value');

        var fieldTagTitleInput = $fieldTagTitleInput.val() || '';
            fieldTagTitleInput = fieldTagTitleInput.trim(),
            fieldTagValueInput = $fieldTagValueInput.val() || '',
            fieldTagValueInput = fieldTagValueInput.trim();

        if( fieldTagTitleInput.length && fieldTagValueInput.length ){

            var tagsModel = new app.MentoringTagsModel({
                nombre_tag_sesion_mentoria: fieldTagTitleInput,
                valor_tag_sesion_mentoria: fieldTagValueInput,
                codigo_mentoria: this.mentoringSessionModel.get('codigo_mentoria')
            });

            window.Misc.setSpinner( this.$el );

            tagsModel.save({
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content')}
            },{success: function(model, resp) {

                window.Misc.removeSpinner({
                    'wrap': _this.$el,
                    'direct': false
                });

                _this.mentoringTagsList.reset(_this.mentoringTagsList.toJSON());

                var text = resp.success ? resp.message : resp.errors,
                                type = resp.success ? 'success' : 'alert';

                            if( _.isObject(resp.errors) ){

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
                            _.extend( _this.configAlert, config );

                if( resp.success ){

                    _this.mentoringTagsList.add(model);
                    $fieldTagTitleInput.val('');
                    $fieldTagValueInput.val('');

                }else{
                    window.Misc.showAlertBox( _this.configAlert );
                }
            }});
        }

        // if( codeKey === 13 ) return false;
    },

    /**
     * Function to create General Objetive
     */
    onAddGeneralObjetive: function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var $fieldGeneralObjetiveInput =  this.$('.body-session-content').find('#mentoring-objetive-general');
        var fieldGeneralObjetiveInput = $fieldGeneralObjetiveInput.val() || '',
        fieldGeneralObjetiveInput = fieldGeneralObjetiveInput.trim();
        var data = {
            'objetive': fieldGeneralObjetiveInput,
            'mentoria': this.mentoringSessionModel.get('codigo_mentoria')
        }

        var _this = this;

        $.post(document.url + Route.route('mentoria.sesiones.objetivo'), data, function(resp) {
            window.Misc.setSpinner( this.$el );

            _this.mentoringSessionModel.set({general_objetive: fieldGeneralObjetiveInput})

            var text = resp.success ? resp.message : resp.errors,
            type = resp.success ? 'success' : 'alert';

            if( _.isObject(resp.errors) ){

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
            _.extend( _this.configAlert, config );

            window.Misc.showAlertBox( _this.configAlert );
        });
    },


    loadSpinner: function(target, xhr, opts) {
        window.Misc.setSpinner( this.$el );
    },

        /**
    * response of the server item delete
    */
    responseItemDelete: function (model, resp, opts) {
        //complete proccess

        window.Misc.removeSpinner({
            'wrap': this.$el,
            'direct': false
        });
    },

    responseServer: function(target, resp, opts) {
        if( !target.length && target instanceof Backbone.Collection && ! _.isUndefined(this.$noResults) )
            this.$noResults.fadeIn('fast');


        window.Misc.removeSpinner({
            'wrap': this.$el,
            'direct': false
        });
    }

   });

})(jQuery, this, this.document);
