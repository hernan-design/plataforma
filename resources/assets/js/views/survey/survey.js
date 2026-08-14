/**
 * Class SurveyView extends of Backbone View
 * @author TuProyecto || Desarrollador : @krobing
 * @link http://TuProyecto.com
 */

//Global App Backbone
app || (app = {});

(function  ($, window, document, undefined) {

    app.SurveyView = Backbone.View.extend({
        el: '#survey-content',
        template: _.template( ($('#wrapper-main-survey-tpl').html() || '') ),
        templateGrouping: _.template( ($('#survey-wrapper-questions-tpl').html() || '') ),
        templateAlert: _.template( ($('#survey-alert-box-tpl').html() || '') ),
        templateInvalidMsg: _.template( ($('#survey-invalid-message-tpl').html() || '') ),
        templateProgress: _.template( ($('#survey-progress-indicator-tpl').html() || '') ),
        events: {
            // 'click .page-next-survey': 'onNextPage',
            'click .page-prev-survey': 'onPrevPage',
            'submit #form-survey-base': 'onStore',
            'change [area-has-subquestion]': 'onCheckSub',
            'invalid.fndtn.abide #form-survey-base': 'onInvalidData',
            'click #continue-after': 'onStore',
            'click .cancel-survey-action': 'onCancel',
            'keyup .grid-matriz-survey input[type=text]': 'onCalculate',
            'change #wrapper-question-5878 input': 'onValidateQuestionRol',
            'change #wrapper-question-5910 input': 'onValidateQuestionRol',
            'change #wrapper-question-5944 input': 'onValidateQuestionRol',
            'change #wrapper-question-5978 input': 'onValidateQuestionRol',
            'change #wrapper-question-5821 input': 'onValidateQuestionObjectives',
            'change #wrapper-question-6026 input': 'onValidateFirstQuestionRutaN',
            'input  #wrapper-question-6375 input': 'onCalculateTotalSiinova'
        },
        parameters: {
            'dataFilter' : {},
            'pageSize': 10,
            'typeSurvey': 'pageable',
            'review': false,
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
            this.listenTo(this.surveyQuestions, 'pageable:state:change', this.renderProgress);

            this.on('beforeRender', this.beforeRender);
            this.on('afterRender', this.afterRender);

        },

        /**
         * Render View Element
         */
        render: function () {

            var attributes = this.model.toJSON();
            attributes.review = this.parameters.review;
            attributes.dataFilter = this.parameters.dataFilter;
            this.$el.html( this.template(attributes) );
            // Initialize renference to elements
            this.$contentQuestions = this.$('#content-asked-questions');
            this.$btnsActions = this.$('.buttons-action-survey');
            this.$formSurvey = this.$('#form-survey-base');
            this.$wrapProgress = this.$('.wrap-progress-indicator');

            // overwrite model id attribute
            if( this.model.changed.codigo_encuesta !== undefined ) {
                this.model.idAttribute = 'codigo_encuesta';
                this.model.set( {'codigo_encuesta': this.model.get('codigo_encuesta')}, {'silent':true} );

                // redefine the URI
                this.model.returnToUrlRoot();
            }

            this.onValidateFirstQuestionRutaN2(attributes);
        },

        /**
         * Fires before of run render function
         */
        beforeRender: function () {
            // code goes here
        },

        /**
         * Fires before of run render function
         */
        afterRender: function () {
            this.ready();
        },

        /**
         * fires libraries js
         */
        ready: function () {
            // trigger libraries
            if( _.has($.fn, 'foundation') ){
                $(document).foundation('abide', 'reflow');
                // $(document).foundation('tab', 'reflow');
            }

            // reassign plugins
            if( typeof(window.initComponent.initConfigForm) == 'function' )
                window.initComponent.initConfigForm();

            // if( typeof(window.initComponent.configSlick) == 'function' && _.has($.fn, 'slick') )
            //  window.initComponent.configSlick();

            if( typeof(window.initComponent.select2Trigger) == 'function' && _.has($.fn, 'select2') )
                window.initComponent.select2Trigger();

            if( typeof(window.initComponent.spinnerTrigger) == 'function' && _.has($.fn, 'sspinner') )
                window.initComponent.spinnerTrigger();

            if( typeof(window.initComponent.datepickerTrigger) == 'function' && _.has($.fn, 'datetimepicker') )
                window.initComponent.datepickerTrigger();

            if( typeof(window.initComponent.configInputMask) == 'function' && _.has($.fn, 'inputmask') )
                window.initComponent.configInputMask();
        },

        renderProgress: function () {
            // console.log('model', this.model); // DEBUG
            // console.log('surveyQuestions', this.surveyQuestions); // DEBUG
            // console.log('params', this.parameters); // DEBUG

            switch (this.model.get('tipo_paginacion_encuesta')) {
                case 1:
                    this.surveyQuestions.state = this.surveyQuestions._checkState(_.extend({}, this.surveyQuestions.state, {
                        pageSize: this.parameters.pageSize,
                        currentPage: this.surveyQuestions.state.currentPage,
                        totalRecords: this.model.get('total_preguntas_padre')
                    }));

                    break;
                case 2:
                    var lastPageGroup= _.max(this.model.get('agrupaciones'), function(agrupacion){ return agrupacion.pagina_grupo_pregunta; });
                    // console.log('lastPageGroup: ', lastPageGroup.pagina_grupo_pregunta);
                    this.surveyQuestions.state = this.surveyQuestions._checkState(_.extend({}, this.surveyQuestions.state, {
                        pageSize: 1,   //gulpthis.parameters.pageSize, //DEBUG
                        currentPage: this.surveyQuestions.state.currentPage,
                        totalRecords: lastPageGroup.pagina_grupo_pregunta      //this.parameters.pageSize
                    }));
                    break;

            }

            // DEBUG
            // console.log('full collection', this.model.get('total_preguntas_padre') );
            // console.log('total records', this.surveyQuestions.state.totalRecords);
            // console.log('total pages',this.surveyQuestions.state.totalPages);
            // console.log('last page', this.surveyQuestions.state.lastPage );

            var pageState = _.extend({}, this.surveyQuestions.state);
            pageState.tipo_porcentaje_avance = this.model.get('tipo_porcentaje_avance');
            pageState.total_preguntas_padre = this.model.get('total_preguntas_padre');
            pageState.total_respuestas_padre = this.model.get('total_respuestas_padre');

            if(pageState.tipo_porcentaje_avance === 1) {
                pageState.percentage = ((pageState.currentPage - 1) / pageState.lastPage) * 100;
            }else {
                pageState.percentage = (pageState.total_respuestas_padre / pageState.total_preguntas_padre) * 100;
            }

            this.$wrapProgress.html( this.templateProgress(pageState) );
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
            if( resp.success != undefined ){
                if( !resp.success )
                    window.Misc.showAlertBox( conf );
            }

            // remove spinner on submit button
            if( this.$formSurvey != undefined ) {

                this.$formSurvey.find(':submit').removeClass('disabled');
            }
        },

        /**
         * Render view question by model
         * @param Object question Model instance
         */
        addOne: function (questionModel, collection, opts) {
            if( opts.onRemove )
                return

            var renderQuestion = '',
                wrapperQuestion = {}
            data = {},
                htmlWrap = '';

            switch( questionModel.get('tipo_pregunta_encuesta') ) {
                case window._tp.typeQuestionSurvey['open']: renderQuestion = 'templateOpenQuestion'; break;
                case window._tp.typeQuestionSurvey['single']: renderQuestion = 'templateSingleQuestion'; break;
                case window._tp.typeQuestionSurvey['multiple']: renderQuestion = 'templateMultipleQuestion'; break;
                case window._tp.typeQuestionSurvey['upload']: renderQuestion = 'templateUploadQuestion'; break;
                case window._tp.typeQuestionSurvey['matriz']: renderQuestion = 'templateMatrizQuestion'; break;
                default: renderQuestion = 'templateOpenQuestion'; break;
            }

            var view = new app.SurveyQuestionView({
                model: questionModel,
                id: 'wrapper-question-'+ questionModel.get('codigo_pregunta_encuesta'),
                className: 'panel-item item-question-survey',
                parameters: {
                    codigo_encuesta: this.model.get('codigo_encuesta'),
                    renderTemplate: renderQuestion,
                    review: this.parameters.review,
                    params: this.parameters.params
                }
            });

            // add a question to position
            if( opts.afterOf instanceof Backbone.Model ) {

                opts.afterOf.trigger('addAfter', view.render().el);
                this.ready();

            }else {

                wrapperQuestion = _.findWhere( this.model.get('agrupaciones'), {codigo_grupo_pregunta_encuesta: questionModel.get('codigo_grupo_pregunta_encuesta')} );

                // add question on wrapper or not
                if( wrapperQuestion ) {

                    if( $('#grouping-survey-'+ wrapperQuestion['codigo_grupo_pregunta_encuesta']).length ) {

                        htmlWrap = $('#grouping-survey-'+ wrapperQuestion['codigo_grupo_pregunta_encuesta']);
                        htmlWrap.append( view.render().el );
                    }else {

                        htmlWrap = this.templateGrouping(wrapperQuestion);
                        this.$contentQuestions.append( $(htmlWrap).append(view.render().el) );
                    }

                }else {
                    this.$contentQuestions.append( view.render().el );
                }
            }
            view.ready();

            // trigger change of checkes and radios
            this.evaluateQuestionOptions(questionModel);

            // call libraries and dependencies
            if( this.surveyQuestions.indexOf(questionModel) >= this.surveyQuestions.length-1 ) {
                this.ready();
            }

            // if( (this.surveyQuestions.indexOf(questionModel) + 1) >= this.surveyQuestions.length ) {
            //     if ( this.$('[area-has-subquestion]').length ) {

            //         window.setTimeout(function () {
            //             this.$('[area-has-subquestion]').trigger('change');
            //         }.bind(this), 500)
            //     }
            // }
        },

        /**
         * evaluate options' sub questions if they are checked or selected
         * @param questionModel Object, question model
         */
        evaluateQuestionOptions: function (questionModel, altChecked) {
            _.isBoolean(altChecked) || (altChecked = null);

            var subOptions = questionModel.get('subpregunta_pregunta') ? questionModel.get('opciones') : {};

            if( subOptions.length ) {

                window.setTimeout(function () {
                    $.each(subOptions, function(key, option) {
                        var typeCheck = null,
                            isChecked = false,
                            dataQuestion = {
                                'pregunta': questionModel.get('codigo_pregunta_encuesta'),
                                'opcion': option.codigo_opcion_encuesta
                            };

                        switch( questionModel.get('tipo_pregunta_encuesta') ){
                            case window._tp.typeQuestionSurvey['single']:
                                typeCheck = 'radio';
                                isChecked = !_.isNull(altChecked) ? altChecked : (questionModel.get('respuesta') == option.codigo_opcion_encuesta);
                                break;
                            case window._tp.typeQuestionSurvey['multiple']:
                                typeCheck = 'checkbox';
                                isChecked = !_.isNull(altChecked) ? altChecked : (_.isArray(questionModel.get('respuesta')) ? _.contains(questionModel.get('respuesta'), option.codigo_opcion_encuesta) : (questionModel.get('respuesta') == option.codigo_opcion_encuesta));
                                break;
                            default: typeCheck = null; isChecked = false; break;
                        }

                        // render or remove sub questions
                        this.renderSubQuestion(dataQuestion, typeCheck, isChecked);

                    }.bind(this));

                }.bind(this), 500);
            }
        },

        /**
         * Render all view question of the collection
         */
        addAll: function () {

            // remove spinner of questions content
            window.Misc.removeSpinner({
                'wrap': this.$el,
                'direct': false
            });

            // Remove questions that was added dynamically
            if( _.isObject(this.showHideQuestions) && this.showHideQuestions[window._tp.classQuestionSurvey['visible']] ) {
                this.surveyQuestions.fullCollection.set( this.showHideQuestions[window._tp.classQuestionSurvey['visible']], {merge:false, add:false, remove:true} );
            }

            // add Current Groups
            this.addCurrentGroups();

            // Buttons actions
            if( this.surveyQuestions.length ) {
                if( this.$btnsActions != undefined ) this.$btnsActions.removeClass('hidesoft');
            }

            $(window).scrollTop(this.$el.offset().top + (-85));
            this.$contentQuestions.html('');

            this.surveyQuestions.forEach( this.addOne, this );
        },

        /**
         * method for add current question groups
         */
        addCurrentGroups: function () {

            var groupsCurrent = _.where(this.model.get('agrupaciones'), {'pagina_grupo_pregunta': this.surveyQuestions.state.currentPage});

            if( groupsCurrent.length && this.model.get('tipo_paginacion_encuesta') == 2 ) {

                var groupCurrentQuestions = this.surveyQuestions.fullCollection.filter(function (question) {
                    return _.findWhere(groupsCurrent, {codigo_grupo_pregunta_encuesta: question.get('codigo_grupo_pregunta_encuesta')}) !== undefined;
                });

                var lastPageGroup= _.max(this.model.get('agrupaciones'), function(agrupacion){ return agrupacion.pagina_grupo_pregunta; });

                if( groupCurrentQuestions.length ) {
                    var oldPage = this.surveyQuestions.state.currentPage;

                    this.surveyQuestions.state = this.surveyQuestions._checkState(_.extend({}, this.surveyQuestions.state, {
                        pageSize: 1,
                        currentPage: oldPage,
                        totalRecords: lastPageGroup.pagina_grupo_pregunta    //this.parameters.pageSize
                    }));

                    this.surveyQuestions.set( groupCurrentQuestions, {merge:false, add:true, remove:true, silent:true} );
                }
            }
        },

        /**
         * add questions to carousel
         * @param String htmlStr
         */
        addQuestion: function (htmlStr) {

            var _this = this;

            // if element content is a carrousel to do another thing
            if( this.$contentQuestions.hasClass('slick-initialized') ) {

                this.$contentQuestions.slick('slickAdd', $( '<div class="panel-questions-survey"></div>' ).wrapInner(htmlStr) );

                // refresh form slick
                window.setTimeout(function () {
                    _this.$contentQuestions.slick('setPosition');
                }, 100);

            }else {
                this.$contentQuestions.append( $( '<div class="panel-questions-survey"></div>' ).wrapInner(htmlStr) );
            }

            this.ready();
        },

        /**
         * build html of questions to carousel
         * @param String htmlStr
         * @param Object question
         */
        buildQuestions: function (htmlStr, question) {

            var renderQuestion = '';

            switch(question['tipo_pregunta_encuesta']) {
                case window._tp.typeQuestionSurvey['open']: renderQuestion = 'templateOpenQuestion'; break;
                case window._tp.typeQuestionSurvey['single']: renderQuestion = 'templateSingleQuestion'; break;
                case window._tp.typeQuestionSurvey['multiple']: renderQuestion = 'templateMultipleQuestion'; break;
                case window._tp.typeQuestionSurvey['upload']: renderQuestion = 'templateUploadQuestion'; break;
                case window._tp.typeQuestionSurvey['matriz']: renderQuestion = 'templateMatrizQuestion'; break;
                default: renderQuestion = 'templateOpenQuestion'; break;
            }

            var view = new app.SurveyQuestionView({
                model: question,
                id: 'wrapper-question-'+ questionModel.get('codigo_pregunta_encuesta'),
                className: 'panel-item item-question-survey',
                parameters: {
                    renderTemplate: renderQuestion,
                    review: this.parameters.review
                }
            });

            htmlStr += view.render().el.outerHTML;

            return htmlStr;
        },

        /**
         * render survey's questions
         * @param Object model
         * @param Mixin value
         */
        renderQuestions: function (model, value) {

            if( this.$btnsActions != undefined ) this.$btnsActions.addClass('hidesoft');

            var _this = this,
                partitionQuestions = [];

            // reset questions content
            if( _.isNull(this.$contentQuestions) || !this.$contentQuestions.length ) {
                return;
            }

            // set per page size
            if( !!Math.floor(this.model.get('paginacion_encuesta')) /*&& !this.parameters.review */) {
                this.parameters.pageSize = Math.floor(this.model.get('paginacion_encuesta'));
            }

            // get shown and hidden questions split
            this.showHideQuestions = _.groupBy(this.model.get('preguntas'), function (question) {
                return question['clase_pregunta_encuesta'];
            });

            if( this.parameters.typeSurvey.toLowerCase() == 'pageable' ) {

                this.surveyQuestions.fullCollection = null;
                this.surveyQuestions.state.totalRecords = this.showHideQuestions[window._tp.classQuestionSurvey['visible']].length;
                this.surveyQuestions.switchMode('client', {
                    fetch : false,
                    resetState : false,
                    models : this.showHideQuestions[window._tp.classQuestionSurvey['visible']]
                });
                this.surveyQuestions.setPageSize(this.parameters.pageSize, {first:true, fetch:false});

                // reassign add handler event to full collection
                this.stopListening(this.surveyQuestions.fullCollection, 'add');
                this.stopListening(this.surveyQuestions.fullCollection, 'remove');
                this.listenTo(this.surveyQuestions.fullCollection, 'add', this.addOne);
                this.listenTo(this.surveyQuestions.fullCollection, 'remove', this.removeSubQuestion);

                // remove preview button if survey is on the first page
                if( !this.surveyQuestions.hasPreviousPage() ){
                    this.$('.page-prev-survey').addClass('hidesoft');
                }else {
                    this.$('.page-prev-survey').removeClass('hidesoft');
                }

                // if the survey does not have next page, change it the button name
                if( !this.surveyQuestions.hasNextPage() ) {

                    // if not confirm button shows its
                    if( !this.parameters.confirmBtn ) {
                        this.$('.page-next-survey').css('visibility', 'hidden');
                    }

                    var oldText = this.$('.page-next-survey').text();
                    this.$('.page-next-survey').text( this.$('.page-next-survey').attr('area-text') )
                        .attr('area-text', oldText);
                }

            }else {

                // if used slick plugin
                if( this.$contentQuestions.hasClass('slick-initialized') ) {
                    this.$contentQuestions.find('.slick-track').html('');
                }

                // partition in custome parts
                partitionQuestions = _.chain(this.model.get('preguntas')).groupBy(function(question, index){
                    return Math.floor(index/_this.parameters.pageSize);
                }).toArray().value();

                // add partition questions
                _.each(partitionQuestions, function (list) {

                    var htmlStr = _.reduce(list, this.buildQuestions, '', this);

                    this.addQuestion(htmlStr);

                }, this);
            }
        },

        /**
         * event to fetch the previous page
         */
        onPrevPage: function (e) {
            e.preventDefault();
            e.stopPropagation();

            if(this.surveyQuestions.hasPreviousPage()) {

                window.Misc.setSpinner( this.$contentQuestions );

                // Remove questions than was added dynamically
                if( _.isObject(this.showHideQuestions) && this.showHideQuestions[window._tp.classQuestionSurvey['visible']] ) {
                    this.surveyQuestions.fullCollection.set( this.showHideQuestions[window._tp.classQuestionSurvey['visible']], {merge:false, add:false, remove:true, silent:true} );
                }

                this.surveyQuestions.getPreviousPage();

                if( this.surveyQuestions.state.currentPage <= this.surveyQuestions.state.firstPage ){
                    this.$('.page-prev-survey').addClass('hidesoft');
                }else {
                    this.$('.page-prev-survey').removeClass('hidesoft');
                }

                if( this.surveyQuestions.state.currentPage+1 == this.surveyQuestions.state.lastPage ){
                    var oldText = this.$('.page-next-survey').text();

                    // if not confirm button shows its
                    if( !this.parameters.confirmBtn ) {
                        this.$('.page-next-survey').css('visibility', 'visible');
                    }

                    if( this.$('.page-next-survey').attr('area-text') !== '' ) {
                        this.$('.page-next-survey').text( this.$('.page-next-survey').attr('area-text') )
                            .attr('area-text', oldText);
                    }
                }
            }
        },

        /**
         * event to fetch the next page
         */
        onNextPage: function (e) {

            if(e !== undefined ) {
                e.preventDefault();
                e.stopPropagation();
            }

            if(this.surveyQuestions.hasNextPage()) {

                // Remove questions than was added dynamically
                if( _.isObject(this.showHideQuestions) && this.showHideQuestions[window._tp.classQuestionSurvey['visible']] ) {
                    this.surveyQuestions.fullCollection.set( this.showHideQuestions[window._tp.classQuestionSurvey['visible']], {merge:false, add:false, remove:true, silent:true} );
                }

                this.surveyQuestions.getNextPage();

                this.$('.page-prev-survey').removeClass('hidesoft');

                if( this.surveyQuestions.state.currentPage >= this.surveyQuestions.state.lastPage ){

                    // if not confirm button hidden its
                    if( !this.parameters.confirmBtn ) {
                        this.$('.page-next-survey').css('visibility', 'hidden');
                    }

                    var oldText = this.$('.page-next-survey').text();

                    this.$('.page-next-survey').text( this.$('.page-next-survey').attr('area-text') )
                        .attr('area-text', oldText);
                }

                // remove spinner on submit button
                if( this.$formSurvey != undefined ) {
                    this.$formSurvey.find(':submit').removeClass('disabled');
                }
            }else {
                if( this.parameters.review )
                    window.history.back(0);
            }
        },

        /**
         * store survey questions
         */
        onStore: function (e) {
            e.preventDefault();
            var _this = this;

            var data = window.Misc.formToJson(this.$formSurvey);
            data.current_page = this.surveyQuestions.state.currentPage;

            // reach to the end
            if( this.surveyQuestions.state.currentPage == this.surveyQuestions.state.lastPage  ) data['ended'] = true;

            // if save and continue after button throws it
            if( $(e.currentTarget).hasClass('btn-continue-after') ) data['continue_after'] = true;
            // add program data filter
            if(this.parameters.dataFilter.program) data['program'] = this.parameters.dataFilter.program;

            // send extra parameters
            _.extend(data, this.parameters.params);

            this.model.save(data, {patch:true, wait:true, success: function (model, resp, opts) {

                    if( !resp.success )
                        return;

                    // merge answer results
                    if( _.isArray(resp.respuestas) ) {
                        _this.surveyQuestions.fullCollection.set(resp.respuestas, {merge:true, add:false, remove:false});

                        // Extend the hidden questions with their respective answers
                        _.each(resp.respuestas, function (answer) {
                            _.chain(_this.showHideQuestions[window._tp.classQuestionSurvey['hidden']])
                                .findWhere({'codigo_pregunta_encuesta': answer.codigo_pregunta_encuesta})
                                .extend(answer).value();
                        });
                    }

                    // redirect to
                    if( !_this.surveyQuestions.hasNextPage() ) {
                        if( resp.message && resp.redirect === false ) {
                        //console.log('nextModel', _this.model.toJSON());
                         //console.log('resp',    resp);
                        //    console.log('el',_this.$el);
                           _this.$el.html( _this.templateAlert({message:resp.message, nickname: _this.model.get('nickname_usuario')}) );
                        }else if( _this.model.get('redirect_to') ) {
                            window.Misc.redirect( window.Misc.urlFull(_this.model.get('redirect_to')) );
                        } else if(resp.redirect) {
                            window.Misc.redirect( window.Misc.urlFull(resp.url_redirect) );
                        }
                    }

                    // pass to next page
                    _this.onNextPage();
                }});

            this.$formSurvey.find(':submit').addClass('disabled');
        },

        /**
         * check out subquestions
         */
        onCheckSub: function (e) {
            e.preventDefault();

            var $checkEl = $(e.currentTarget);

            // field is a select
            if($checkEl.is('select')) $checkEl = $(e.currentTarget).find(':selected');

            var indx = $checkEl.prop('id'),
                typeCheck = null,
                isChecked = false;

            // split question code and option code
            var dataQuestion = _.chain(indx.split('_')).groupBy(function(question, index){
                return Math.floor(index/2);
            }).toArray().object().value();

            // type check
            if($checkEl.is(':checkbox')) {
                typeCheck = 'checkbox';
            }else if($checkEl.is(':radio') || $checkEl.is('option')) {
                typeCheck = 'single';
            }

            // is checked
            isChecked = $checkEl.is(':checked') || $checkEl.is(':selected');

            // render or remove sub questions
            this.renderSubQuestion(dataQuestion, typeCheck, isChecked);
        },

        /**
         * render or remove sub questions
         * @param Object dataQuestion
         * @param String typeCheck
         * @param Boolean isChecked
         */
        renderSubQuestion: function (dataQuestion, typeCheck, isChecked) {
            dataQuestion || (dataQuestion = {});
            typeCheck || (typeCheck = '');
            isChecked || (isChecked = false);

            var toAddQuestions = [],
                toRemoveQuestions = [],
                addAt = -1,
                addTo = 'question';

            var afterOf = this.surveyQuestions.findWhere({ 'codigo_pregunta_encuesta':parseInt(dataQuestion['pregunta']) });

            if( afterOf instanceof Backbone.Model ) {
                addAt = this.surveyQuestions.indexOf( afterOf ) + 1;
            }else {
                afterOf = this.surveyQuestions.fullCollection.findWhere({ 'codigo_pregunta_encuesta':parseInt(dataQuestion['pregunta']) });
                addAt = this.surveyQuestions.fullCollection.indexOf( afterOf ) + 1;
                addTo = 'subquestion';
            }

            // find relate questions
            if( isChecked ) {
                toAddQuestions = _.where(this.showHideQuestions[window._tp.classQuestionSurvey['hidden']], {'pregunta_padre': parseInt(dataQuestion['pregunta']), 'codigo_opcion_encuesta': parseInt(dataQuestion['opcion'])});

                if( typeCheck.toLowerCase() == 'single' ){
                    toRemoveQuestions = _.chain(this.showHideQuestions[window._tp.classQuestionSurvey['hidden']]).filter(function (question) {
                        return ( question['pregunta_padre'] == parseInt(dataQuestion['pregunta']) &&
                            question['codigo_opcion_encuesta'] != parseInt(dataQuestion['opcion']) );
                    }).pluck('codigo_pregunta_encuesta').value();
                }

            }else {
                toRemoveQuestions = _.chain(this.showHideQuestions[window._tp.classQuestionSurvey['hidden']]).where({'pregunta_padre': parseInt(dataQuestion['pregunta']), 'codigo_opcion_encuesta': parseInt(dataQuestion['opcion'])}).pluck('codigo_pregunta_encuesta').value();
            }

            // remove questions
            if( toRemoveQuestions.length ){

                this.surveyQuestions.fullCollection.remove( this.surveyQuestions.fullCollection.filter(function (questionModel) {
                    return _.contains(toRemoveQuestions, questionModel.get('codigo_pregunta_encuesta'));
                }) );
            }

            // add questions
            this.surveyQuestions.fullCollection.add(toAddQuestions, {addTo: addTo, afterOf: afterOf});

            // console.log(this.surveyQuestions, this.surveyQuestions.state );
        },

        /**
         * remove subquestion from parent questions
         */
        removeSubQuestion: function (model, collection, opts) {

            // trigger change of checkes and radios
            this.evaluateQuestionOptions(model, false);
        },

        /**
         * validate data
         */
        onInvalidData: function (e) {

            window.Misc.showAlertBox(_.extend({}, this.configAlert,{
                text: this.templateInvalidMsg({}),
                type: 'alert'
            }));

            var $target = $(e.target).find(':input[data-invalid]:eq(0)').parents('.item-question-survey');

            var $parentScroll = $target.parents().filter(function () {
                return ( _.contains(['fixed','relative'], $(this).css('position')) && _.contains(['auto','scroll'], $(this).css('overflow')) ) || $(this).is('body');
            }).eq(0);

            if( $parentScroll.is('body') ) {

                $parentScroll.animate({
                    scrollTop: ( $target.offset().top - 85 ) + 'px'
                }, {
                    duration: 1000,
                    easing: 'swing',
                    complete: null
                });

            }else {
                $parentScroll.animate({
                    scrollTop: '+=' + ( $target.offset().top - 85 ) + 'px'
                }, {
                    duration: 1000,
                    easing: 'swing',
                    complete: null
                });
            }
        },

        /**
         * cancel button
         */
        onCancel: function (e) {
            e.preventDefault();

            var _this = this;

            var cancelConfirm = new window.app.ConfirmWindow({
                parameters: {
                    template: _.template( ($('#survey-cancel-message-tpl').html() || '') ),
                    titleConfirm: 'Cancelar postulación',
                    onConfirm: function () {
                        window.Misc.redirect( window.Misc.urlFull( Route.route( 'encuesta.cancelar', {'encuesta': _this.model.get('codigo_encuesta'), 'program': _this.parameters['dataFilter'].program ? _this.parameters['dataFilter'].program : '' }) ) );
                    }
                }
            });
            cancelConfirm.render();
        },

        onCalculate: function (e) {

            var _this = this;
            var $inputField = $(e.target);

            // split question code, option code and field code
            var dataQuestion = _.chain( $inputField.attr('id').split('_') ).groupBy(function(question, index){
                return Math.floor(index/2);
            }).toArray().object().value();

            dataQuestion['slug'] = $inputField.data('slug') || null;

            // var questionCal = this.surveyQuestions.findWhere({ 'codigo_pregunta_encuesta': parseInt(dataQuestion.pregunta) });
            var questionsCal = this.surveyQuestions.where({ 'tipo_pregunta_encuesta': window._tp.typeQuestionSurvey['matriz'] });

            // loop for each option to calculate
            if( questionsCal !== undefined ) {

                _.each( questionsCal, function (questionCal) {

                    _.each( _.where(questionCal.get('opciones'), {'calculado_opcion_encuesta': true}), function (option) {

                        // if math expression is not empty
                        if( !_.isUndefined(option.formula_opcion_encuesta) && !_.isNull(option.formula_opcion_encuesta) && option.formula_opcion_encuesta !== '' ) {

                            var expressionsCal = window.Misc.validateMathExpressions(option.formula_opcion_encuesta),
                                result = 0,
                                campoSlug = dataQuestion.slug || dataQuestion.campo;

                            result = _this.resultExpressions(expressionsCal, {pregunta: questionCal.get('codigo_pregunta_encuesta'), campo: campoSlug});

                            if( isNaN(result) ) result = 0;


                            _this.$('#pregunta_'+ questionCal.get('codigo_pregunta_encuesta') +'_opcion_'+ option.codigo_opcion_encuesta +'_campo_'+ campoSlug).val( result )
                                .trigger('setvalue');
                        }

                    });
                });
            }
        },

        resultExpressions: function (expressionsCal, params) {

            var parameters = _.extend({}, {
                pregunta: null,
                campo: null
            }, params);

            var result = _.reduce(expressionsCal, function (memo, expCalc, index) {

                if( _.isArray(expCalc) ) {
                    expCalc = this.resultExpressions(expCalc, parameters);
                }

                var valConcact = /^p\d+[xy]/.test(expCalc) ?
                    $('#pregunta_'+ expCalc.replace(/^p|[xy]\d+/g,'') +'_opcion_'+ expCalc.replace(/^p\d+[xy]/,'') +'_campo_'+ parameters.campo).inputmask('unmaskedvalue')
                    : (/^[xy]/.test(expCalc) ? $('#pregunta_'+ parameters.pregunta +'_opcion_'+ expCalc.replace(/^[xy]/,'') +'_campo_'+ parameters.campo).inputmask('unmaskedvalue') : expCalc);


                try {
                    return eval( (''+memo).concat(valConcact) );

                }catch(err){
                    return (''+memo).concat(valConcact);
                }

            }, '0+', this);

            return result;
        },

        /**
         *
         * @param {e} e datos de etiqueta input y etiqueta padre
         */
         onValidateQuestionRol: function (e) {

            var sons_checked = '';
            var parent = $(e.target).parents()[4].id; // 'wrapper-question-5878';
            var elementsChecked = $('#'+parent+' input:checked');

            if (elementsChecked.length == 2) {
                for (var index = 0; index < elementsChecked.length; index++) {
                    if (index == 0) {
                        sons_checked = '#' + $('#' + parent + ' input:checked')[index].id;
                    } else if (index == 1) {
                        sons_checked += ', #' + $('#' + parent + ' input:checked')[index].id;
                    }
                }

                $('#'+parent+' input').not($(sons_checked)).attr( "disabled", true ); //ocultar elementos

            } else {
                $('#'+parent+' input').not($(sons_checked)).attr( "disabled", false ); //mostrar todos elementos
            }

            if (elementsChecked.length > 2) {
                $('#'+parent+' input').attr( "checked", false ); //mostrar todos elementos
            }
           // console.log($('#wrapper-question-5878 input:checked') );

          //  console.log($(e.target).parents()[4].id); //saber parent
           //var contenido = document.querySelectorAll('#wrapper-question-5878 input:checked');
        },

        /**
         *
         * @param {e} e datos de etiqueta input y etiqueta padre
         */
        onValidateQuestionObjectives: function (e) {

            var sons_checked = '';
            var parent = $(e.target).parents()[4].id; // 'wrapper-question-5821';
            var elementsChecked = $('#'+parent+' input:checked');

            if (elementsChecked.length == 3) {
                for (var index = 0; index < elementsChecked.length; index++) {
                    if (index == 0) {
                        sons_checked = '#' + $('#' + parent + ' input:checked')[index].id;
                    } else if (index == 1) {
                        sons_checked += ', #' + $('#' + parent + ' input:checked')[index].id;
                    } else if (index == 2) {
                        sons_checked += ', #' + $('#' + parent + ' input:checked')[index].id;
                    }
                }

                $('#'+parent+' input').not($(sons_checked)).attr( "disabled", true ); //disabled elementos

            } else {
                $('#'+parent+' input').not($(sons_checked)).attr( "disabled", false ); //not disabled all elements
            }

            if (elementsChecked.length > 3) {
                $('#'+parent+' input').attr( "checked", false ); //mostrar todos elementos
            }
        },

        onValidateFirstQuestionRutaN: function (e) {
            if (e.target.id == 'pregunta_6026_opcion_11846') {
                $(".page-next-survey").attr( "disabled", true ); //disabled button

                const text = '¡Lo sentimos! El formulario debe ser diligenciado por una persona que viva en Medellin. Dile a alguien de tu equipo de trabajo que resida en la ciudad que se encargue del registro';
                const type = 'alert';

                var config = {
                    'text': text,
                    'type': type
                };

                _.extend( this.configAlert, config );

                window.Misc.showAlertBox( this.configAlert );

            } else {
                $(".page-next-survey").attr( "disabled", false ); //disabled button
            }
        },

        onValidateFirstQuestionRutaN2: function (attributes) {
            if (attributes.url_encuesta == 'ruta-n' && attributes.preguntas) {
                if (attributes.preguntas[0].respuesta && attributes.preguntas[0].respuesta == 11846) {
                    $(".page-next-survey").attr( "disabled", true ); //disabled button
                } else {
                    $(".page-next-survey").attr( "disabled", false ); //disabled button
                }
            }
        },

        onCalculateTotalSiinova: function () {

            //Inhabilita el campo con id. $("#id").attr => JQuery
            $('#pregunta_6375_opcion_13838_campo_13839').attr('readonly');

            var valueDoctor2021 = document.getElementById("pregunta_6375_opcion_13829_campo_13839").value;
            var valueMaestria2021 = document.getElementById("pregunta_6375_opcion_13830_campo_13839").value;
            var valueEspecializacion2021 = document.getElementById("pregunta_6375_opcion_13831_campo_13839").value;
            var valueUniversitario2021 = document.getElementById("pregunta_6375_opcion_13832_campo_13839").value;
            var valueTecnologo2021 = document.getElementById("pregunta_6375_opcion_13833_campo_13839").value;
            var valueTecnico2021 = document.getElementById("pregunta_6375_opcion_13834_campo_13839").value;
            var valueSecundaria2021 = document.getElementById("pregunta_6375_opcion_13835_campo_13839").value;
            var valuePrimaria2021 = document.getElementById("pregunta_6375_opcion_13836_campo_13839").value;

            var total2021 = parseFloat(valueDoctor2021)+parseFloat(valueMaestria2021)+parseFloat(valueEspecializacion2021)+parseFloat(valueUniversitario2021)+
                    parseFloat(valueTecnologo2021)+parseFloat(valueTecnico2021)+parseFloat(valueSecundaria2021)+parseFloat(valuePrimaria2021);

            document.getElementById("pregunta_6375_opcion_13838_campo_13839").value = total2021;

            var valueDoctor2022 = document.getElementById("pregunta_6375_opcion_13829_campo_13840").value;
            var valueMaestria2022 = document.getElementById("pregunta_6375_opcion_13830_campo_13840").value;
            var valueEspecializacion2022 = document.getElementById("pregunta_6375_opcion_13831_campo_13840").value;
            var valueUniversitario2022 = document.getElementById("pregunta_6375_opcion_13832_campo_13840").value;
            var valueTecnologo2022 = document.getElementById("pregunta_6375_opcion_13833_campo_13840").value;
            var valueTecnico2022 = document.getElementById("pregunta_6375_opcion_13834_campo_13840").value;
            var valueSecundaria2022 = document.getElementById("pregunta_6375_opcion_13835_campo_13840").value;
            var valuePrimaria2022 = document.getElementById("pregunta_6375_opcion_13836_campo_13840").value;

            var total2022 = parseFloat(valueDoctor2022)+parseFloat(valueMaestria2022)+parseFloat(valueEspecializacion2022)+parseFloat(valueUniversitario2022)+
                    parseFloat(valueTecnologo2022)+parseFloat(valueTecnico2022)+parseFloat(valueSecundaria2022)+parseFloat(valuePrimaria2022);

            document.getElementById("pregunta_6375_opcion_13838_campo_13840").value = total2022;
        },

    });

})(jQuery, this, this.document);
