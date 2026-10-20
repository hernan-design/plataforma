/**
* Class AppRouter  of Backbone Router
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.AppRouter = new( Backbone.Router.extend({
        routes : {
            'mentoria/preguntas/create': 'getMentoringQuestionCreate',
            'mentoria/preguntas/evaluacion/mentor/create/:user': 'toEvaluationMentor',
            'mentoria/preguntas/:question(?*queryString)': 'getMentoringQuestion',
            'mentoria/preguntas(?*queryString)': 'getQuestionsMain',
            'mentoria/mentores/create': 'getMentoringCreateMentor',
            'mentoria/mentores/procesos(?*queryString)': 'getMentoringProccess',
            'mentoria/mentores/procesos/:mentor': 'getMentorProcess',
            'mentoria/mentores/:mentor': 'getMentorProfile',
            'mentoria/mentores(?*queryString)': 'getMentorsMain',
            'mentoria(?*queryString)': 'getMentorsMain',
            'proyecto/create': 'getCreateProject',
            'proyecto/:proyecto(/:tab)': 'getProject',
            'proyecto(/:type)(?*queryString)': 'getProjectMain',
            'convocatoria(/)(?*queryString)': 'getCallMain',
            'convocatoria/:convocatoria': 'getCall',
            'convocatoria/:convocatoria/aplicar/:step(?*queryString)': 'applyToProgram',
            'usuario(/)(?*queryString)': 'getUserMain',
            'usuario/:nickname(/:tab)(?*queryString)': 'getUser',
            'aprende/:type/:category/:course/formulario/:survey': 'getCourseSurvey',
            'aprende/:type/:category/:course/contenido/:theme/:clase': 'getCourseClass',
            'aprende/:type/:category/:course/contenido': 'getCourseContent',
            'aprende/:type/:category/:course': 'getCourse',
            'aprende/:type/:category': 'getLearnCategory',
            'aprende(/:type)(?*queryString)': 'getLearnMain',
            'aprende/biometric/:uri': 'getBiometricValidation',
            'blog/create': 'getBlogCreate',
            'blog/:category/:article': 'getArticle',
            'blog(/:category)': 'getBlogMain',
            'blog(/)(?*queryString)': 'getBlogMain',
            'marketplace/compras/payment/:payment/edit(?*queryString)': 'getPayment',
            'marketplace/compras/acuerdo/:purchase': 'getPurchaseAgreement',
            'marketplace/compras/create(?*queryString)': 'getPurchaseOrder',
            'marketplace/compras/evaluaciongeneral(/)(?*queryString)': 'getPurchaseGeneralEvaluation',
            'marketplace/compras/:purchase/create(?*queryString)': 'getPurchaseOffer',
            'marketplace/compras': 'getMarketPlaceBuyer',
            'marketplace/ventas/acuerdo/:agreement/edit': 'getMarketPlaceSaleAgrement',
            'marketplace/ventas/acuerdo/create/:sale': 'getMarketPlaceAgreement',
            'marketplace/ventas/create': 'getMarketPlaceSeller',
            'marketplace/ventas/promocion/create': 'getMarketPlaceCreatePromotion',
            'marketplace/ventas/promocion/:promocion/edit': 'getMarketPlaceEditPromotion',
            'marketplace/ventas/promocion(/)(?*queryString)': 'getMarketPlacePromotions',
            'marketplace/ventas(?*queryString)': 'getMarketPlaceSale',
            'marketplace/misproductos(/)(?*queryString)': 'getMarketPlaceMyProducts',
            'marketplace/favoritos(/)(?*queryString)': 'getMarketPlaceMyFavorites',
            'marketplace/:tab/evaluacion/:evaluacion': 'getPurchaseEvaluation',
            'marketplace/:tab/entregables/:purchase': 'getDeliverablesAgreement',
            'marketplace/create': 'getMarketPlaceCreateProduct',
            'marketplace/:product(?*queryString)': 'getMarketPlaceProduct',
            'marketplace(/)(?*queryString)': 'getMarketPlaceMain',
            'calendario/evento/:event': 'getEvent',
            'calendario/:calendar': 'getCalendar',
            'calendario(/evento)': 'getCalendarMain',
            'search(/)(?*queryString)': 'getSearchMain',
            'grupo/:grupo(/:tab)': 'getGroup',
            'grupo(/)(?*queryString)': 'getGroupMain',
            'encuesta/aplicar/:syrvey/:user(?*queryString)': 'getSurvey',
            'encuesta/responder/:survey(?*queryString)': 'getSurveyResponse',
            'encuesta/revision/:survey/:usersurvey': 'getSurveyReview',
            'register(/)': 'initRegister',
            'notificaciones(/)': 'getNotificationMain',
            'discusion/:discusion': 'getDiscussion',
            'evaluacion/:evaluacion': 'getEvaluationProject',
            'evaluacion(/)(?*queryString)': 'getEvaluationProjectsMain',
            'step/perfil': 'getStepProfile',
            'step/entidad': 'getStepEntity',
            'step/canales': 'getStepChannels',
            'step/compromiso/:compromiso/edit': 'getCommitmentMiddleware',
            'voto/verify/:vote': 'verifyVote',
        },

        /**
        * Constructor Method
        */
        initialize : function ( opts ){
            // Initialize resources
            // Matches route proyecto
            this.route(/^proyecto\/(empresas|proyectos|grupos|micontenido)\??(.*)?/, 'getProjectMain');

            /*Login Resources*/
            this.googleRecaptchaView = new app.GoogleRecaptchaView({ });

            this.socialRegisterView = new app.GoogleRecaptchaView({
                el: $('#register-section')
            });
            this.userSingUpView = new app.UserSingUpView({});

            /*Global Resources*/
            this.sectionTitleView = new app.SectionTitleView();

            this.breadcrumbModel = new app.BreadcrumbModel();
            this.breadcrumbView = new app.BreadcrumbView( {model: this.breadcrumbModel} );
            $( '.navegation-bc' ).html( this.breadcrumbView.render().el );

            /*Middleware Resources*/
            this.userModel = new app.UserModel();
            this.verifyAccount = new app.VerifyAccountView( );

            this.eventModel = new app.EventModel();
            this.eventModal = new app.EventModalView( {model: this.eventModel} );
            $('#main-wrap').prepend( this.eventModal.render().el );

            /*Wall Resources*/
            this.urlMetaDataModel = new app.UrlMetaDataModel();
            this.previewPost = new app.PreviewPostView( {model: this.urlMetaDataModel} );

            /*Mentoring Resources*/
            this.baseMetoring = new app.BaseMentoringView();

            this.adviceModel = new app.AdviceModel();
            this.mentorModel = new app.MentorModel();

            // this.mentoringView = new app.MentoringView({ model:this.adviceModel });

            /*Mentoring Evaluation Resources*/
            this.mentoringEvaluationModel = new app.MentoringEvaluationModel();
            this.mentoringModel = new app.MentoringModel();
            this.mentoringCalificationTaskModel = new app.MentoringCalificationTaskModel();

            /*Project Resources*/
            this.baseProjectView = new app.BaseProjectView();
            // this.projectList = new app.ProjectList();
            this.groupList = new app.GroupList();
            this.projectCreateView = new app.ProjectCreateView({ model: new app.ProjectModel() });

            /*Call Resources*/
            this.callList = new app.CallList();

            /*Course Resources*/
            this.courseList = new app.CourseList();
            this.courseListView = new app.CourseBrowseListView( {collection: this.courseList, attributes:{type: 'cursos'}} );
            this.baseCourseView = new app.BaseCourseView();

            /*Blog Resources*/
            this.blogArticleModel = new app.BlogArticleModel();
            this.blogArticleList = new app.BlogArticlesList();
            this.basesArticleView = new app.BasesArticleView();

            /*MarketPlace Resources*/
            this.baseMarketPlaceView = new app.BaseMarketPlaceView();

            /*Calendar events Resources*/
            this.calendarEventList = new app.EventList();
            this.calendarEventsView = new app.EventListView( {collection: this.calendarEventList} );

            /*User Resources*/
            this.usersList = new app.UsersList();

            /*Evaluator projects resources*/
            this.evaluationProjectBase = new app.EvaluationProjectBaseView();

            /*Notification Resources*/
            this.notificationList = new app.NotificationList();

            //Events handlers
            this.on('route', this.checkSection );
            // this.on('route:getMentoringMain route:getMentoringQuestion route:getMentoringSession route:getProjectMain route:getProject route:getCreateProject route:getCallMain route:getCall route:getLearnMain route:getLearnCategory route:getCourse route:getCourseContent route:getBlogMain route:getBlogCreate route:getArticleCategory route:getArticle route:getMentoringCalificationTask route:toMentoringEvalSession route:getMarketPlaceMain  route:getMarketPlaceProduct route:getCalendarMain route:getEvent route:getUserMain route:getMarketPlaceSeller route:getMarketPlaceCreateProduct route:getMarketPlaceBuyer route:getMarketPlaceSale route:getMarketPlaceMyProducts route:getMarketPlaceMyFavorites route:getSearchMain route:getGroupMain route:getGroup route:getNotificationMain route:applyToProgram route:getMentoringCreateMentor route:getMentorsMain route:getMentorProfile route:toEvaluationMentor route:getQuestionsMain route:getDiscussion route:getEvaluationProjectsMain route:getEvaluationProject', this.buildBreadcrumb );
            /*handlers*/
            this.on('route:getProject route:getGroup route:getProjectMain route:getCallMain route:getCall', this.triggerTitle );
            this.on('route:getMarketPlaceMain route:getMarketPlaceMyProducts route:getMarketPlaceMyFavorites route:getLearnMain route:getLearnCategory route:getCourse route:getBlogMain route:getArticle route:getSearchMain route:getCallMain route:getProjectMain route:getGroupMain route:getEvaluationProjectsMain', this.filterMenu);
        },

        isOpenedMenu: false,

        /**
        * execute before a route
        */
        execute: function (callback, args, name) {
            // clean breadcrumb
            // $('.navegation-bc .breadcrumbs').html('');

            if (callback) callback.apply(this, args);

            // clean menu filter
            this.isOpenedMenu = $('.fx-col-left, .fx-col-right').hasClass('is-hide');
            $('#side-menu-filter').html('');
            $('.fx-col-left, .fx-col-right').addClass('is-hide');
        },

        /**
        * Start Backbone history
        */
        start: function () {
            var config = { pushState: true };

            if( document.domain.search(/(192.168.0.10|localhost)/gi) != '-1' )
                config.root = '/plataforma/public/';

            Backbone.history.start( config );

            this.handleClick();
        },

        /**
        * to handle the Route of the links
        */
        handleClick: function () {

            var _this = this;
            $( document ).on('click', 'a', function (e){

                var toRoute = $( e.currentTarget ).attr('href');
                if(!toRoute) return;

                //if Route begins with hash does not continue
                if( (/^\#/).test(toRoute) )
                    return;
                
                // Avoid intercepting target blank
                if ($(e.currentTarget).attr('target') === '_blank') return;
                
                var origin = window.location.origin || (window.location.protocol + "//" + window.location.host);

                // Is this an internal link?
                if (toRoute.indexOf(origin) === 0) {
                    toRoute = toRoute.replace(origin, '');
                } else if (/^http(s)?:\/\//.test(toRoute)) {
                    // It's an external link
                    return;
                } else if (!/^\//.test(toRoute)) {
                    // Doesn't start with origin, http, or /, ignore (like mailto:, tel:)
                    return;
                }

                // If we get here, it's an internal link
                e.preventDefault();

                _this.navigate(toRoute, {trigger: true});
            });
        },

        /**
        * Parse queryString to object
        */
        parseQueryString : function(queryString) {
            var params = {};
            if(queryString) {
                _.each(
                    _.map(decodeURI(queryString).split(/&/g),function(el,i){
                        var aux = el.split('='), o = {};
                        if(aux.length >= 1){
                            var val = undefined;
                            if(aux.length == 2)
                                val = aux[1];
                            o[aux[0]] = val;
                        }
                        return o;
                    }),
                    function(o){
                        _.extend(params,o);
                    }
                );
            }
            return params;
        },

        /**
        * get posts most recent
        */
        buildBreadcrumb : function () {
            this.breadcrumbModel.fetch( {data: {'path': Backbone.history.fragment}} );
        },

        /**
        * get filter menu
        */
        filterMenu : function () {

            $('.fx-col-left, .fx-col-right').toggleClass('is-hide', this.isOpenedMenu);

            var section = Backbone.history.fragment.split('?')[0],
                queries = this.parseQueryString( Backbone.history.location.search.split('?')[1] );

            var parameters = {
                'section': section,
                'dataFilter': queries,
                'params': _.toArray(arguments)
            };

            // Instance view Filter Menu for marketplace
            if ( this.menuFilterView instanceof Backbone.View ){
                this.menuFilterView.stopListening();
                this.menuFilterView.undelegateEvents();
            }

            this.menuFilterView = new app.MenuFilterView( {parameters:parameters} );

            // Render view filter menu
            this.menuFilterView.render();

            $('.hide-fx-left-btn, .hide-fx-right-btn').toggleClass('on', this.isOpenedMenu);
        },

        /**
        * Trigger Title
        */
        triggerTitle: function () {
            // this.forumTitleView.trigger('title:category', undefined);
            this.sectionTitleView.trigger('title:subtitle', undefined);
        },

        // Routes on App
        // --------------------
        /**
        * check the browser url section
        */
        checkSection: function (route, params) {

            var section = Backbone.history.fragment.split('/')[0];

            if( section != '' && ({}).toString.call(section).slice(8,-1) === 'String' ){

                $('[data-section]').removeClass('active')
                                   .filter('[data-section*="'+ section.toLowerCase() +'"]')
                                   .addClass('active');

                $('[data-section]').parents('.has-dropdown')
                                       .find('> a').removeClass('active')
                                   .end()
                                   .end().filter('[data-section*="'+ section.toLowerCase() +'"]')
                                   .parents('.has-dropdown')
                                       .find('> a').addClass('active');
            }
        },

        /**
        * Init Main Mentoring
        * @param String rol
        * @param String tab
        * @param String queryString
        */
        getQuestionsMain: function (queryString) {
            var queries = this.parseQueryString(queryString);

            queries.v || (queries.v = 'list');

            this.baseMetoring.parameters = {'tab': 'preguntas', 'dataFilter': queries};
            this.baseMetoring.render();
        },

        /**
        * show view mentoring question
        * @param String rol
        * @param String tab
        * @param String question
        * @param String queryString
        */
        getMentoringQuestion: function (question, queryString) {

            var queries = this.parseQueryString(queryString);
            queries.filter || (queries.filter = 'filtro');

            this.baseMetoring.parameters = { 'tab': 'preguntas', 'action': question };
            this.baseMetoring.render();

            // render view question detail
            this.adviceModel.idAttribute = 'url_asesoria';
            this.adviceModel.set({'url_asesoria': question}, {'silent':true});

            if ( this.mentoringQuestion instanceof Backbone.View ){
                this.mentoringQuestion.stopListening();
                this.mentoringQuestion.undelegateEvents();
            }

            this.mentoringQuestion = new app.MentoringQuestionView({ model:this.adviceModel });
            this.adviceModel.fetch();
        },

        /**
        * show view mentoring session
        * @param String rol
        * @param String tab
        * @param String question
        * @param String queryString
        */
        getMentoringSession: function (rol, session, queryString) {
            rol || (rol = 'emprendedor');

            var queries = this.parseQueryString(queryString);
            queries.filter || (queries.filter = 'filtro');

            this.baseMetoring.parameters = {'rol': rol, 'tab': 'sesiones', 'action': session };
            this.baseMetoring.render();

            // render view session detail
            this.adviceModel.idAttribute = 'url_mentoria';
            this.mentoringModel.set({'url_mentoria': session}, {'silent':true});

            if ( this.mentoringSessionView instanceof Backbone.View ){
                this.mentoringSessionView.stopListening();
                this.mentoringSessionView.undelegateEvents();
            }

            this.mentoringSessionView = new app.MentoringSessionView({ model: this.mentoringModel });
            this.mentoringModel.fetch();
        },

        /**
        * Init mentoring to evaluation session
        */
        toMentoringEvalSession: function (rol, queryString) {

            rol || (rol = 'emprendedor');

            var queries = this.parseQueryString(queryString);
            queries.filter || (queries.filter = 'filtro');

            this.baseMetoring.parameters = {'rol': rol, 'tab': 'sesiones', 'action': 'session' };
            this.baseMetoring.render();

            this.mentoringModel.set({'url_mentoria': queries.m}, {silent: true});

            if ( this.mentoringEvalSessionView instanceof Backbone.View ){
                this.mentoringEvalSessionView.stopListening();
                this.mentoringEvalSessionView.undelegateEvents();
            }

            this.mentoringEvalSessionView = new app.MentoringEvalSessionView( { model: this.mentoringModel} );
            this.mentoringModel.fetch();

        },

        /**
        * show view in Mentoring Calification Task
        * @param String show
        */
        getMentoringCalificationTask: function (rol, queryString) {

            rol || (rol = 'mentor');

            var queries = this.parseQueryString(queryString);
            queries.filter || (queries.filter = 'filtro');

            this.baseMetoring.parameters = {'rol': rol, 'tab': 'sesiones', 'action': 'session' };
            this.baseMetoring.render();

            this.mentoringModel.set({'url_mentoria': queries.m}, {silent: true});

            if ( this.mentoringCalificationTaskView instanceof Backbone.View ){
                this.mentoringCalificationTaskView.stopListening();
                this.mentoringCalificationTaskView.undelegateEvents();
            }

            this.mentoringCalificationTaskView = new app.MentoringCalificationTaskView( { model: this.mentoringModel} );
            this.mentoringModel.fetch();
        },

        /**
        * render create project form
        */
        getCreateProject: function() {

            var projectCreateView = new app.ProjectCreateView({
                el: '#project-content',
                template: _.template( ($('#form-create-project-tpl').html() || '') ),
                model: new app.ProjectModel()
            });
            projectCreateView.render();
        },

        /**
        * Init Main Project
        */
        getProjectMain: function (type, queryString) {
            type || ( type = 'principal' );

            var queries = this.parseQueryString(queryString);
            queries.v || (queries.v = 'grid');

            var parameters = {
                type: type,
                dataFilter: queries
            };

            // Render view marketplace base
            this.baseProjectView.parameters = parameters;
            this.baseProjectView.render();
        },

        /**
        * show view in project
        * @param String theme
        * @param String show
        */
        getProject: function (project, tab) {
            this.projectModel = new app.ProjectModel();
            this.projectModel.idAttribute = 'url_nickname';
            this.projectModel.set({'url_nickname': project}, {silent: true});

            tab || (tab = 'basico');

            var parameters = {
                tab: tab,
                type: 'detail',
                dataFilter: {},
                project: this.projectModel
            };

            // Render view marketplace base
            this.baseProjectView.parameters = parameters;
            this.baseProjectView.render();
        },

        /**
        * Init Main Calls
        */
        getCallMain: function (queryString) {

            var queries = this.parseQueryString(queryString);

            var parameters = {
                dataFilter: queries
            };

            if ( this.callListView instanceof Backbone.View ){
                this.callListView.stopListening();
                this.callListView.undelegateEvents();
            }

            this.callListView = new app.CallListView( {collection:this.callList} );

            // Render list program
            this.callListView.parameters = parameters;
            this.callListView.render();
            this.callListView.trigger('getdata');
        },

        /**
        * show view in call
        * @param String call
        */
        getCall: function (call) {

            this.callModel = new app.CallModel();
            this.callModel.idAttribute = 'url_convocatoria';
            this.callModel.set('url_convocatoria', call, {silent:true});

            if ( this.callView instanceof Backbone.View ){
                this.callView.stopListening();
                this.callView.undelegateEvents();
            }

            this.callView = new app.CallView({ model: this.callModel, parameters: {oldView: this.callView} });
            this.callModel.fetch();

        },

        /**
        * show user profile view
        * @param String nickname
        */
        getUser: function (nickname, tab, queryString) {
            var queries = this.parseQueryString(queryString);

            if(!window.Misc.checkSession(false) && tab != 'basico') {
                this.navigate( Route.route('usuario.nickname.tab', {nickname: nickname, tab: 'basico'}), {trigger: true} );
                return;
            }

            this.userProfileModel = new app.UserModel();
            this.userProfileModel.idAttribute = 'nickname_usuario';
            this.userProfileModel.set({'nickname_usuario': nickname}, {'silent':true});

            if ( this.userProfileView instanceof Backbone.View ){
                this.userProfileView.stopListening();
                this.userProfileView.undelegateEvents();
            }

            tab || (tab = 'basico');
            this.userProfileView = new app.UserProfileView( {model: this.userProfileModel, parameters: { tab: tab, 'dataFilter': queries } } );

            this.userProfileModel.fetch();
        },

        /**
        * Init Main Learn
        */
        getLearnMain: function (type, queryString) {

            type || ( type = 'principal' );

            var queries = this.parseQueryString(queryString);

            var parameters = {
                type: type,
                action: '',
                dataFilter: queries
            };

            // Render view course base
            this.baseCourseView.parameters = parameters;
            this.baseCourseView.render();
        },

        /**
        * show list course by category
        * @param String theme
        * @param String show
        */
        getLearnCategory: function (type, category) {

            type || ( type = 'cursos' );

            var data = { category: category, type: type };
            var parameters = {
                dataFilter: data,
                type: type
            };
            // Render view
            this.courseListView.parameters = parameters;
            this.courseListView.render();
            this.courseListView.trigger('getData');
        },

        /**
        * show view in Course
        * @param String theme
        * @param String show
        */
        getCourse: function (type, category, course) {
            $('#lecture-course').html('');

            this.courseModel = new app.CourseModel();
            this.courseModel.idAttribute = 'url_curso';
            this.courseModel.set({'url_curso': course}, {'silent':true});

            if ( this.courseView instanceof Backbone.View ){
                this.courseView.stopListening();
                this.courseView.undelegateEvents();
            }

            this.courseView = new app.CourseView({ model: this.courseModel, attributes: { type: type } });
        },

        /**
        * show view in ContentCourse
        * @param String theme
        * @param String show
        */
        getCourseContent: function (type, category, course) {
            $('#lecture-course').html('');

            if(window.Misc.checkSession(true)) {

                this.courseModel = new app.CourseModel();
                this.courseModel.idAttribute = 'url_curso';
                this.courseModel.set( {'url_curso': course}, {'silent':true} );

                if ( this.courseContentView instanceof Backbone.View ){
                    this.courseContentView.stopListening();
                    this.courseContentView.undelegateEvents();
                }

                this.courseContentView = new app.CourseContentView({ model: this.courseModel, attributes: { type: type } });

                this.courseModel.fetch();
            }
        },

        /**
        * show view in CourseClass
        * @param String theme
        * @param String show
        */
        getCourseClass: function (type, category, course, theme, lecture) {

            if(window.Misc.checkSession(true)) {

                if ( this.courseClassView instanceof Backbone.View ){
                    // this.courseClassView.stopListening();
                    this.courseClassView.undelegateEvents();
                }

                var parameters = {
                    course: course,
                    theme: theme,
                    lecture: lecture,
                    type: type
                };

                this.courseModel = new app.CourseModel();
                this.courseModel.idAttribute = 'url_curso';
                this.courseModel.set( {'url_curso': course}, {'silent':true} );

                this.courseClassView = new app.CourseClassView({ model: this.courseModel, parameters: parameters });

                this.courseModel.fetch();
            }
        },

        /**
        * show view Biometric Valitaion
        * @param String theme
        * @param String show
        */

        getBiometricValidation: function (uri) {
            console.log('aqui')
            if(window.Misc.checkSession(true)) {

                if ( this.courseClassView instanceof Backbone.View ){
                    // this.courseClassView.stopListening();
                    this.courseClassView.undelegateEvents();
                }

                var parameters = {
                    course: uri,
                    theme: uri,
                    lecture: uri,
                    type: uri
                };

                this.courseModel = new app.CourseModel();
                this.courseModel.idAttribute = 'url_curso';
                this.courseModel.set( {'url_curso': uri}, {'silent':true} );

                this.courseClassView = new app.CourseClassView({ model: this.courseModel, parameters: parameters });

                this.courseModel.fetch();
            }
        },


         /**
        * show view in CourseClass
        * @param String theme
        * @param String show
        */
       getCourseSurvey: function (type, category, course, survey) {
        if(window.Misc.checkSession(true)) {

            if ( this.courseSurveyView instanceof Backbone.View ){
                this.courseSurveyView.stopListening();
                this.courseSurveyView.undelegateEvents();
            }

            var parameters = {
                course: course,
                category:category,
                survey: survey,
                type: type
            };
            this.courseModel = new app.CourseModel();
            this.courseModel.idAttribute = 'url_curso';
            this.courseModel.set( {'url_curso': course}, {'silent':true} );

            this.courseSurveyView = new app.CourseSurveyView({ model: this.courseModel, parameters: parameters });

            this.courseModel.fetch();
        }
    },

        /**
        * Init Main Blog
        */
        getBlogMain: function (category, queryString) {

            category || (category = '');
            var data = { category: category };

            var queries = this.parseQueryString(queryString);

            var parameters = {
                tab: 'browse',
                action: '',
                dataFilter: _.extend({v:'list'}, queries)
            };

            this.basesArticleView.dataArticle = data;
            this.basesArticleView.parameters = parameters;

            // Render view
            this.basesArticleView.render();
        },

        /**
        * Create Blog
        */
        getBlogCreate: function () {
            var parameters = {
                tab: 'createArticle',
                action: '',
                dataFilter: {}
            };

            // Render view
            this.basesArticleView.parameters = parameters;
            this.basesArticleView.render();
        },

        /**
        * show view in Article
        * @param String theme
        * @param String show
        */
        getArticle: function (category, article) {

            this.blogArticleModel.idAttribute = 'url_contenido';
            this.blogArticleModel.set({'url_contenido': article}, {'silent':true});
            this.blogArticleModel.url = function () {
                return window.Misc.urlFull( Route.route('blog.categoria.articulo', {category: category, article: article}) );
            };

            if ( this.articleView instanceof Backbone.View ){
                this.articleView.stopListening();
                this.articleView.undelegateEvents();
            }

            this.articleView = new app.ArticleView({
                model: this.blogArticleModel,
                attributes: {
                    category: category,
                    article: article
                }
            });

            this.blogArticleModel.fetch();
        },

        /**
        * Init Main MarketPlace
        */
        getMarketPlaceMain: function (queryString) {
            var queries = this.parseQueryString(queryString);

            var parameters = {
                tab: 'browse',
                action: '',
                dataFilter: _.extend({v:'list'}, queries)
            };

            // Render view marketplace base
            this.baseMarketPlaceView.parameters = parameters;
            this.baseMarketPlaceView.render();
        },

        /**
        * show view in DetailProduct
        * @param String theme
        * @param String show
        */
        getMarketPlaceProduct: function (product, queryString) {

            var queries = {},
                data = {
                    'url_producto': product
                };

            if(!_.isNull(queryString)){
                queries = this.parseQueryString(queryString);
                data.promotion_code = queries;
            }

            this.marketPlaceModel = new app.MarketPlaceModel();
            this.marketPlaceModel.idAttribute = 'url_producto';
            this.marketPlaceModel.set( data, {'silent':true} );

            if ( this.marketPlaceDetailView instanceof Backbone.View ){
                this.marketPlaceDetailView.stopListening();
                this.marketPlaceDetailView.undelegateEvents();
            }

            this.marketPlaceDetailView = new app.MarketPlaceDetailView({
                model: this.marketPlaceModel,
                parameters: {
                    params: queries
                }
            });
            this.marketPlaceModel.fetch();
        },

        /**
        * show create form seller marketplace
        * @param Strign queryString
        */
        getMarketPlaceSeller: function () {
            var parameters = {
                tab: 'createSeller',
                action: '',
                dataFilter: {v:'list'}
            };

            // Render view marketplace base
            this.baseMarketPlaceView.parameters = parameters;
            this.baseMarketPlaceView.render();
        },

        /**
        * get my marketplace promotions
        */
        getMarketPlacePromotions: function (queryString) {
            var queries = this.parseQueryString(queryString),
                parameters = {
                    tab: 'myPromotions',
                    action: '',
                    dataFilter: _.extend({type:'owner',v:'list'}, queries)
                };

            // Render view marketplace base
            this.baseMarketPlaceView.parameters = parameters;
            this.baseMarketPlaceView.render();
        },

        /**
        * show create form seller promotion marketplace
        */
        getMarketPlaceCreatePromotion: function () {
            var parameters = {
                tab: 'createPromotion',
                action: '',
                dataFilter: {v:'list'}
            };

            // Render view marketplace base
            this.baseMarketPlaceView.parameters = parameters;
            this.baseMarketPlaceView.render();
        },

        /**
        * show edit form promotion marketplace
        */
        getMarketPlaceEditPromotion: function (promotion) {
            var parameters = {
                tab: 'createPromotion',
                action: '',
                dataFilter: {promotion: promotion}
            };

            // Render view marketplace base
            this.baseMarketPlaceView.parameters = parameters;
            this.baseMarketPlaceView.render();
        },

        /**
        * show create form product marketplace
        */
        getMarketPlaceCreateProduct: function () {
            var parameters = {
                tab: 'createProduct',
                action: '',
                dataFilter: {}
            };

            // Render view marketplace base
            this.baseMarketPlaceView.parameters = parameters;
            this.baseMarketPlaceView.render();
        },

        /**
        * show Buys form product marketplace
        */
        getMarketPlaceBuyer: function () {
            var parameters = {
                tab: 'myBuys',
                action: '',
                dataFilter: {}
            };

            // Render view marketplace base
            this.baseMarketPlaceView.parameters = parameters;
            this.baseMarketPlaceView.render();
        },

        /**
        * show Sales form product marketplace
        */
        getMarketPlaceSale: function (queryString) {
            var queries = this.parseQueryString(queryString),
                parameters = {
                    tab: 'mySales',
                    action: '',
                    dataFilter: _.extend({}, queries)
                };

            // Render view marketplace base
            this.baseMarketPlaceView.parameters = parameters;
            this.baseMarketPlaceView.render();
        },

        /**
        * get my marketplace products
        */
        getMarketPlaceMyProducts: function (queryString) {
            var queries = this.parseQueryString(queryString),
                parameters = {
                    tab: 'myProducts',
                    action: '',
                    dataFilter: _.extend({type:'owner',v:'list'}, queries)
                };

            // Render view marketplace base
            this.baseMarketPlaceView.parameters = parameters;
            this.baseMarketPlaceView.render();
        },

        /**
        * get my marketplace favorites
        */
        getMarketPlaceMyFavorites: function (queryString) {
            var queries = this.parseQueryString(queryString);

            var parameters = {
                tab: 'myFavorites',
                action: '',
                dataFilter: _.extend({type:'favorites',v:'list'}, queries)
            };

            // Render view marketplace base
            this.baseMarketPlaceView.parameters = parameters;
            this.baseMarketPlaceView.render();
        },

        /**
        * render marketplace base
        * show create form product marketplace
        */
        getPurchaseOrder: function (queryString) {

            var queries = this.parseQueryString(queryString);
            if(!window.Misc.checkSession(false)) {
                window.Misc.redirect( window.Misc.urlFull(Route.route( 'marketplace.compras.create', queries)) );
                return;
            }
            var purchase_id =  queries.purchase || '';


            this.marketPlaceModel = new app.MarketPlaceModel();
            this.marketPlaceModel.idAttribute = 'url_producto';
            this.marketPlaceModel.set( {'url_producto': queries.product, 'purchase':purchase_id}, {'silent':true} );

            if ( this.marketPlacePurchaseView instanceof Backbone.View ){
                this.marketPlacePurchaseView.stopListening();
                this.marketPlacePurchaseView.undelegateEvents();
            }

            this.marketPlacePurchaseView = new app.MarketPlacePurchaseView({
                model: this.marketPlaceModel,
                parameters: {
                    'dataFilter': queries
                }
            });
            this.marketPlaceModel.fetch();
        },

        /**
         * render marketplace base
         * show create form product marketplace for offer
         */
        getPurchaseOffer: function (purchase, queryString) {

            var queries = this.parseQueryString(queryString);
            queries.purchase = purchase || '';
            if(!window.Misc.checkSession(false)) {
                window.Misc.redirect( window.Misc.urlFull(Route.route( 'marketplace.compras.offer.create', queries)) );
                return;
            }

            this.purchaseModel = new app.PurchaseModel();

            this.marketPlaceModel = new app.MarketPlaceModel();
            this.marketPlaceModel.idAttribute = 'url_producto';
            this.marketPlaceModel.set( {'url_producto': queries.product, 'purchase': queries.purchase}, {'silent':true} );

            if ( this.marketPlacePurchaseView instanceof Backbone.View ){
                this.marketPlacePurchaseView.stopListening();
                this.marketPlacePurchaseView.undelegateEvents();
            }


            this.marketPlacePurchaseView = new app.MarketPlacePurchaseView({
                model: this.marketPlaceModel,
                parameters: {
                    'dataFilter': queries
                }
            });
            this.marketPlaceModel.fetch();
        },

        /**
         * render marketplace purchase evaluation
         * show create form evaluation purchase marketplace
         */
        getPurchaseEvaluation: function (tab, purchase) {
            this.purchaseModel = new app.PurchaseModel();
            this.purchaseModel.set( {'codigo_compra': purchase}, {'silent':true} );

            if ( this.purchaseEvaluationView instanceof Backbone.View ){
                this.purchaseEvaluationView.stopListening();
                this.purchaseEvaluationView.undelegateEvents();
            }

            this.purchaseEvaluationView = new app.MarketPlacePurchaseEvaluationView({
                model: this.purchaseModel,
                parameters: {
                    'tab': tab
                }
            });
            this.purchaseModel.fetch({data: {type:'attachment'}});
        },

        /**
         * render marketplace purchase evaluation
         * show create form evaluation purchase marketplace
         */
        getPurchaseGeneralEvaluation: function () {

            this.voucherModel = new app.VoucherModel();


            if ( this.purchaseGeneralEvaluationView instanceof Backbone.View ){
                this.purchaseGeneralEvaluationView.stopListening();
                this.purchaseGeneralEvaluationView.undelegateEvents();
            }

            this.purchaseGeneralEvaluationView = new app.MarketPlacePurchaseGeneralEvaluationView({
                model: this.voucherModel
            });
            this.voucherModel.fetch();

        },

        /**
        * render marketplace deliverables agreement
        * show deliverables agreement form marketplace
        */
        getDeliverablesAgreement: function (tab, purchase) {
            this.purchaseModel = new app.PurchaseModel();
            this.purchaseModel.set( {'codigo_compra': purchase}, {'silent':true} );

            if ( this.deliverablesAgreementView instanceof Backbone.View ){
                this.deliverablesAgreementView.stopListening();
                this.deliverablesAgreementView.undelegateEvents();
            }

            this.deliverablesAgreementView = new app.DelirablesAgreementView({
                model: this.purchaseModel,
                parameters: {
                    'tab': tab
                }
            });
            this.purchaseModel.fetch({data: {type:'attachment'}});
        },

        /**
        * create marketplace sale agreement
        */
        getMarketPlaceAgreement: function (sale) {

            var parameters = {
                'sale': sale,
                'tab': 'ventas'
            };

            if( this.createSaleAgreement instanceof Backbone.View ){
                this.createSaleAgreement.stopListening();
                this.createSaleAgreement.undelegateEvents();
            }

            this.createSaleAgreement = new app.CreateSaleAgreementView( {parameters: parameters} );
            this.createSaleAgreement.render();
        },

        /**
        * editing marketplace sale agreement
        */
        getMarketPlaceSaleAgrement: function (agreement) {

            var parameters = {
                'tab': 'ventas'
            };

            if( this.createSaleAgreement instanceof Backbone.View ){
                this.createSaleAgreement.stopListening();
                this.createSaleAgreement.undelegateEvents();
            }

            this.createSaleAgreement = new app.CreateSaleAgreementView( {parameters: parameters} );
            this.createSaleAgreement.model.set('codigo_acuerdo_compra', agreement, {silent:true});
            this.createSaleAgreement.model.fetch();
        },

        /**
        * get purchase agreement
        */
        getPurchaseAgreement: function (agreement) {
            var parameters = {
                'tab': 'compras'
            };

            if( this.createSaleAgreement instanceof Backbone.View ){
                this.createSaleAgreement.stopListening();
                this.createSaleAgreement.undelegateEvents();
            }

            this.createSaleAgreement = new app.CreateSaleAgreementView( {parameters: parameters} );
            this.createSaleAgreement.model.set('codigo_acuerdo_compra', agreement, {silent:true});
            this.createSaleAgreement.model.fetch();
        },

        /**
        * Init Main Calendar
        */
        getCalendarMain: function () {

            var dataEvents = {
                type: "calendar"
            };

            // Render view
            this.calendarEventsView.render();

            // Fetch data
            this.calendarEventsView.trigger('getData', dataEvents);
        },

        /**
         * Get specific calendar
         */
        getCalendar: function(calendar) {
            var calendar = calendar.toLowerCase().trim();

            var dataEvents = {
                type: "calendar",
                calendar: calendar
            };

            // Render view
            this.calendarEventsView.render();

            // Fetch data
            this.calendarEventsView.trigger('getData', dataEvents);
        },

        /**
        * show view in Calendar Event
        * @param String show
        */
        getEvent: function (event) {

            this.eventModel.set({'codigo_evento': event }, {'silent':true});

            if ( this.eventView instanceof Backbone.View ){
                this.eventView.stopListening();
                this.eventView.undelegateEvents();
            }

            this.eventView = new app.EventView({
                model: this.eventModel
            });
            this.eventModel.fetch();
        },

        /**
        * show user profile view
        * @param String queryString
        */
        getUserMain: function (queryString) {
            var queries = this.parseQueryString(queryString);

            this.userListView = new app.UserListView({
                collection: this.usersList,
                parameters: {
                    'dataFilter': queries
                }
            });
            this.userListView.render();
            this.userListView.trigger('getdata');
        },

        /**
        * show search view
        * @param String queryString
        */
        getSearchMain: function (queryString) {
            //
        },

        /**
        * Init Main Group
        */
        getGroupMain: function (queryString) {

            var queries = this.parseQueryString(queryString);
            queries.v || (queries.v = 'list');

            var parameters = { dataFilter: queries };

            if ( this.groupListView instanceof Backbone.View ){
                this.groupListView.stopListening();
                this.groupListView.undelegateEvents();
            }

            this.groupListView = new app.GroupListView({ collection: this.groupList, parameters: parameters });
            this.groupListView.render();
            this.groupListView.trigger('getdata');
        },

        /**
        * show view in group
        * @param String theme
        * @param String show
        */
        getGroup: function (group, tab) {

            tab || (tab = 'basico');

            this.groupModel = new app.GroupModel();
            this.groupModel.idAttribute = 'url_proyecto';
            this.groupModel.set({'url_proyecto': group},{'silent':true});

            if ( this.groupView instanceof Backbone.View ){
                this.groupView.stopListening();
                this.groupView.undelegateEvents();
            }

            this.groupView = new app.GroupView({ model: this.groupModel, parameters: { tab: tab } });
            this.groupModel.fetch();
        },

        /**
        * get survey
        * @param survey
        */
        getSurvey: function (survey, user, queryString) {
            var queries = this.parseQueryString(queryString);
            queries.url_encuesta = survey;
            queries.codigo_usuario = user;

            this.surveyModel = new app.SurveyModel();
            this.surveyModel.idAttribute = 'url_encuesta';
            this.surveyModel.set({'url_encuesta': survey}, {'silent':true});

            if( this.surveyView instanceof Backbone.View ) {
                this.surveyView.stopListening();
                this.surveyView.undelegateEvents();
            }

            this.surveyView = new app.SurveyView({
                model: this.surveyModel,
                parameters: {
                    params: queries
                }
            });
            this.surveyModel.fetch({ data: queries });
        },

        getSurveyResponse: function (survey, queryString) {

            var queries = this.parseQueryString(queryString);

            this.surveyModel = new app.SurveyModel();
            this.surveyModel.idAttribute = 'url_encuesta';
            this.surveyModel.set({'url_encuesta': survey}, {'silent':true});

            if( this.surveyView instanceof Backbone.View ) {
                this.surveyView.stopListening();
                this.surveyView.undelegateEvents();
            }

            this.surveyView = new app.SurveyView({
                model: this.surveyModel,
                parameters: {
                    params: queries
                }
            });
            this.surveyModel.fetch({ data: queries });
        },

        /**
        * get survey preview
        * @param survey
        */
        getSurveyReview: function (survey, usersurvey) {

            this.surveyModel = new app.SurveyModel();
            this.surveyModel.idAttribute = 'url_encuesta';
            this.surveyModel.set({'url_encuesta': survey}, {silent:true});

            if( this.surveyPreview instanceof Backbone.View ) {
                this.surveyPreview.stopListening();
                this.surveyPreview.undelegateEvents();
            }

            this.surveyPreview = new app.SurveyReview({ model:this.surveyModel });

            this.surveyModel.fetch({ data:{'codigo_usuario_encuesta' : usersurvey} });
        },

        /**
        * show step user profile view
        * @param String nickname
        */
        getStepProfile: function () {
            var userProfileModel = new app.UserModel();
            userProfileModel.url = function () {
                return window.Misc.urlFull( Route.route('usuario.auth') );
            };

            if ( this.stepProfileView instanceof Backbone.View ){
                this.stepProfileView.stopListening();
                this.stepProfileView.undelegateEvents();
            }

            this.stepProfileView = new app.StepProfileView( {model: userProfileModel } );
            userProfileModel.fetch();
        },

        /**
        * show step create entity view
        */
        getStepEntity: function () {
            // Instance create project view
            var projectCreateView = new app.ProjectCreateView({
                el: '#step-entity-form',
                model:new app.ProjectModel(),
                parameters: {
                    'redirect': window.Misc.urlFull( Route.route('step.canales') )
                }
            });
        },

        /**
        * show step choice channels view
        */
        getStepChannels: function () {

            if ( this.stepChannelsView instanceof Backbone.View ){
                this.stepChannelsView.stopListening();
                this.stepChannelsView.undelegateEvents();
            }

            this.stepChannelsView = new app.StepChannelsView({ });
        },

        /**
        * initialize settings of register
        */
        initRegister: function () {

            var modelRegisterSurvey = new app.SurveyModel(),
                sendParams = {
                    module: 'register'
                };

            modelRegisterSurvey.url = function () {
                return window.Misc.urlFull( Route.route('encuesta.register') );
            };

            if( this.surveyView instanceof Backbone.View ) {
                this.surveyView.stopListening();
                this.surveyView.undelegateEvents();
            }


            this.surveyView = new app.SurveyView({
                el: $('#register-section #survey-content'),
                model: modelRegisterSurvey,
                parameters: {
                    params: sendParams
                }
            });

            if( $('#register-section #survey-content').length )
                modelRegisterSurvey.fetch();
        },

        /**
        * Init Main Notification
        */
        getNotificationMain: function () {

            if ( this.notificationListView instanceof Backbone.View ){
                this.notificationListView.stopListening();
                this.notificationListView.undelegateEvents();
            }

            // Render view notificationListView base
            this.notificationListView = new app.NotificationListView( {collection: this.notificationList} );
            this.notificationListView.render();
            this.notificationListView.trigger('getdata');

        },

        /**
        * Init Main Payment
        */
        getPayment: function (payment, queryString) {
            var parameters = { 'purchase': payment };

            if(!_.isNull(queryString)){
                parameters.promotion_code = queryString;
            }

            this.marketplacePaymentView = new app.MarketplacePaymentView( {parameters: parameters} );
            this.marketplacePaymentView.render();
        },

        /**
        * apply to program
        * @param String convocatoria
        * @param String step
        * @param String queryString
        */
        applyToProgram: function (convocatoria, step, queryString) {

            var queries = this.parseQueryString(queryString);

            var parameters = {
                url_convocatoria: convocatoria,
                step: step,
                dataFilter: queries
            };

            if( this.applyProgramView instanceof Backbone.View ) {
                this.applyProgramView.stopListening();
                this.applyProgramView.undelegateEvents();
            }

            // instance and render apply program view
            this.applyProgramView = new app.ApplyProgramView( {parameters: parameters} );
            this.applyProgramView.trigger('getdata');
        },

        /**
        * show create form mentor
        * @param user
        */
        getMentoringCreateMentor: function () {

            this.baseMetoring.parameters = {'action': 'mentor' };
            this.baseMetoring.render();
        },

        /**
        * Init Main Group
        */
        getMentorsMain: function (queryString) {

            var queries = this.parseQueryString(queryString);
            this.baseMetoring.parameters = {'tab': 'mentores', 'action': 'mentores', 'dataFilter': queries};
            this.baseMetoring.render();
        },

        getMentoringProccess: function(queryString) {

            var queries = this.parseQueryString(queryString);
            this.baseMetoring.parameters = {'tab': 'process', 'action': 'process', 'dataFilter': queries};
            this.baseMetoring.render();
        },

        getMentorProcess: function(mentor) {
            var code_mentor = mentor;
            this.baseMetoring.parameters = {'tab': 'sesiones', 'action': 'sesiones'};
            this.baseMetoring.render();

            this.mentorSessionModel = new app.MentoringSessionModel();
            this.mentorSessionModel.idAttribute = 'codigo_mentoria';
            this.mentorSessionModel.set({'codigo_mentoria': code_mentor}, {'silent':true});

            if ( this.proccesMentor instanceof Backbone.View ){
                this.proccesMentor.stopListening();
                this.proccesMentor.undelegateEvents();
            }

            this.proccesMentor = new app.ProcessMentor({ model: this.mentorSessionModel });
            this.mentorSessionModel.fetch();
        },

        /**
        * show view create question mentoring
        */
        getMentoringQuestionCreate: function (queryString) {

            var queries = this.parseQueryString(queryString);
            this.baseMetoring.parameters = {'tab': 'crearpregunta', 'action': 'crearpregunta', 'dataFilter': queries};
            this.baseMetoring.render();
        },

        /**
        * show view mentor
        * @param user
        */
        getMentorProfile: function (mentor) {
            this.mentorProfileModel = new app.MentorModel();

            this.mentorProfileModel.idAttribute = 'codigo_usuario';
            this.mentorProfileModel.set({'codigo_usuario': mentor}, {'silent':true});

            if ( this.profileMentorView instanceof Backbone.View ){
                this.profileMentorView.stopListening();
                this.profileMentorView.undelegateEvents();
            }

            this.profileMentorView = new app.ProfileMentorView({ model: this.mentorProfileModel });
            this.mentorProfileModel.fetch();
        },

        /**
        * Init mentoring to evaluation mentor
        */
        toEvaluationMentor: function (user) {

            // render view evaluation mentor
            this.adviceEvalModel = new app.AdviceModel();
            this.adviceEvalModel.idAttribute = 'codigo_asesoria';
            this.adviceEvalModel.set({'codigo_asesoria': user}, {'silent':true});

            if ( this.mentorEvaluationView instanceof Backbone.View ){
                this.mentorEvaluationView.stopListening();
                this.mentorEvaluationView.undelegateEvents();
            }

            this.mentorEvaluationView = new app.MentorEvaluationView({ model: this.adviceEvalModel });
            this.adviceEvalModel.fetch({data: {type:'encrypt'}});
        },

        /**
        * show view discussion
        * @param discussion
        */
        getDiscussion: function (discussion) {

            // render view discussion
            this.discussionModel = new app.DiscussionModel();
            this.discussionModel.idAttribute = 'codigo_discucion';
            this.discussionModel.set({'codigo_discucion': discussion}, {'silent':true});

            if ( this.discussionView instanceof Backbone.View ){
                this.discussionView.stopListening();
                this.discussionView.undelegateEvents();
            }

            this.discussionView = new app.DiscussionView({ model: this.discussionModel });
            this.discussionModel.fetch();
        },

        /**
        * show list evaluator
        */
        getEvaluationProjectsMain: function (queryString) {
            var queries = this.parseQueryString(queryString);

            var parameters = {
                section: 'evaluationList',
                dataFilter: queries
            };

            this.evaluationProjectBase.parameters = _.extend({}, this.evaluationProjectBase.parameters, parameters);
            this.evaluationProjectBase.render();
        },

        /**
        * show view evaluator
        */
        getEvaluationProject: function (evaluation) {
            var parameters = {
                section: 'evaluation',
                evaluation: evaluation
            };

            if ( this.evaluationProjectBase instanceof Backbone.View ){
                this.evaluationProjectBase.stopListening();
                this.evaluationProjectBase.undelegateEvents();
            }

            this.evaluationProjectBase.parameters = parameters;
            this.evaluationProjectBase.render();
        },

        /**
        * show commitment middleware
        */
        getCommitmentMiddleware: function (compromiso) {

            $('#form-commitment-middleware :submit').off('click');
            $('#form-commitment-middleware :submit').on('click', function (event) {
                event.preventDefault();

                var $elForm = $(event.target).closest('form');

                // Confirm commitment
                this.confirmCommitment = new app.ConfirmWindow({
                    // model: this.model,
                    parameters: {
                        template: _.template( ($('#commitment-confirm-tpl').html() || '') ),
                        titleConfirm: '¡Aceptar carta de compromiso!',
                        onConfirm: function () {
                            var _self = this;

                            $elForm.submit();
                        }
                    }
                });
                this.confirmCommitment.render();
            });
        },

        verifyVote: function(vote) {

            if ( this.voteVerifyView instanceof Backbone.View ){
                this.voteVerifyView.stopListening();
                this.voteVerifyView.undelegateEvents();
            }

            this.voteVerifyView = new app.VoteVerifyView({
                parameters: {
                    vote: vote
                }
            });

            this.voteVerifyView.render();
        }

    }) );

})(jQuery, this, this.document);
