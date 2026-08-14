/**
* Class CourseClassView extend of Backbone View
* @autor TuProyecto || Desarrollador : @xindykatalina, @refo44
* @link http://TuProyecto.com
*/

// Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CourseClassView = Backbone.View.extend({

        el: '#course-content',
        template: _.template( ($('#course-course-theme-lecture-tpl').html() || '') ),
        templatePlayer: _.template( ($('#course-lecture-video-tpl').html() || '') ),
        template_navbar: _.template( ($('#learn-navbar-button').html() || '') ),
        events: {
            'click .prev-video': 'onPrevVideo',
            'click .next-video': 'onNextVideo'
        },
        parameters: {},
        player: null,
        currentTheme: {},
        currentLecture: {},

        /**
        * Constructor Method
        */
        initialize: function(opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'readyPlayer');
            // extends parameters
            if (opts !== undefined && _.isObject(opts.parameters)) {
                this.parameters = _.extend({}, this.parameters, opts.parameters);
            }

            // Init Attributes
            this.courseThemeList = new app.CourseThemeList();
            this.discussionList = new app.DiscussionList();
            this.courseAttachmentsList = new app.CourseAttachmentsList();
            this.userNotesList = new app.UserNotesList();

            var _this = this;
            this.render = _.wrap(this.render, function(render) {
                _this.trigger('beforeRender');
                render();
                _this.trigger('afterRender');
                return _this;
            });

            // Events Listener
            this.listenTo(this.courseThemeList, 'changeVideo', this.changeVideo);
            this.listenTo(this.model, "change", this.render);
            this.on('beforeRender', this.beforeRender);
            this.on('afterRender', this.afterRender);
        },

        /*
        * Render View Element
        */
        render: function() {
            var _this = this,
                attributes = this.model.toJSON();

            if (_.isObject(this.parameters) && this.parameters.type !== undefined) {
                attributes.type = this.parameters.type;
            }
            this.$el.html(this.template_navbar(attributes));
            this.$el.append(this.template(attributes));

            // initialize elements
            this.$themesCourse = this.$('#side-course-themes');
            this.$lectureVideo = this.$('#course-lecture-video');
            this.$wrapperDiscussion = this.$('#wrapper-lecture-discussion');
            this.$wrapperAttached = this.$('#side-course-attachments');
            this.$wrapperUserNote = this.$('#side-course-notes');
            this.$titleCourse = this.$('#title-lecture-main');
            this.$descriptionCourse = this.$('#description-lecture-main');
            this.stateAttachedTheme = this.$('.state-attached-theme');
            this.modal = this.$('#modal-log-cursos');
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function() {
        },

        /**
        * Fires after of run render function
        */
        afterRender: function() {
            // reference to views
            this.refenrenceToTabs();

            // initialize dependencies
            this.ready();

            const _this = this;  // Use `const` to fix the scope issue

            document.addEventListener("visibilitychange", (event) => {
                if (document.visibilityState == "visible") {
                    console.log("tab is active");
                } else {
                    console.log("tab is inactive");

                   console.log(_this.model.get('codigo_curso'));

                    // Datos que quieres enviar en la solicitud
                    const dataToSend = {
                        // Añade aquí los datos que necesitas enviar
                        codigo_curso: _this.model.get('codigo_curso'),
                        codigo_usuario: _this.model.get('codigo_usuario'),
                        tipo_log: 1
                    };

                    // Realizar solicitud AJAX
                    fetch('/log_curso', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Si usas tokens CSRF
                        },
                        body: JSON.stringify(dataToSend) // Datos a enviar en la solicitud
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Lógica después de la respuesta AJAX
                        console.log(data);

                        const modal = _this.modal;
                        if (modal.length) { // Verificar si el elemento modal existe
                            // Mostrar modal
                            modal.css("display", "block");
                            const baseUrl = window.location.origin + "/aprende/cursos";

                            // Agregar event listener para el botón "Ok"
                            document.getElementById('modal-ok-button').addEventListener('click', () => {
                                const baseUrl = window.location.origin + "/aprende/cursos";
                                window.location = baseUrl;
                            });
                            // Redirigir después de 3 segundos
                            // setTimeout(() => {
                            //     window.location = baseUrl;
                            // }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });

        },

        /**
        * reference to tabs's views
        */
        refenrenceToTabs: function() {
            var _this = this;

            // instance course themes
            this.courseThemeListView = new app.CourseThemeListView({
                el: this.$themesCourse,
                collection: this.courseThemeList,
                attributes: {
                    'type': this.parameters.type,
                    'viewTheme': 'CourseThemeClassItemView'
                }
            });

            // instance of discussion view
            this.discussionListView = new app.DiscussionListView({
                el: this.$wrapperDiscussion,
                collection: this.discussionList,
                parameters: {
                    'formDiscussion': '#form-discussion-course',
                    dataFilter: {
                        'codigo_recurso_modulo': this.model.get('codigo_curso'),
                        'codigo_modulo': window._tp.getModule('learn')
                    }
                }
            });

            // instance of attached view
            this.courseAttachedListView = new app.CourseAttachedListView({
                el: this.$wrapperAttached,
                collection: this.courseAttachmentsList,
                parameters: {
                    'course': this.parameters.course
                }
            });

            // instance of usernotes view
            this.userNoteListView = new app.UserNoteListView({
                el: this.$wrapperUserNote,
                collection: this.userNotesList,
                parameters: {
                    'course': this.parameters.course
                }
            });

            // fetch course themes
            this.courseThemeList.fetch({
                data: { 'course': this.parameters.course, 'content': true, 'advance': true },
                reset: true,
                success: function(collection, resp, opts) {
                    var lecture = _this.courseThemeList.getLecture(_this.parameters.course, _this.parameters.theme, _this.parameters.lecture);
                    var model = _this.courseThemeList.findWhere({ 'url_tema_curso': _this.parameters.theme });

                    _this.changeVideo(lecture, model);
                }
            });
        },

        /**
        * fires libraries js and functions
        */
        ready: function() {
            // trigger libraries
            if (_.has($.fn, 'foundation')) {
                this.$el.foundation('abide');
                $(document).foundation('tab', 'reflow');
            }

            // trigger functions
            if (typeof window.initComponent.configScrollbar == 'function')
                window.initComponent.configScrollbar();
        },

        /**
        * listener when select video
        * @param Object lecture
        * @param Object model
        */
        changeVideo: function(lecture, model) {
            var srcVideo = lecture !== undefined ? lecture.direccion_adjunto + (lecture.includeparams || '') : '';

            var attributes = {
                src: window.Misc.convertVideoEmbed(srcVideo, 'watch'),
                codigo_tipo_adjunto: typeof lecture !== 'undefined' ? lecture.codigo_tipo_adjunto : null
            };

            if (typeof lecture !== 'undefined' && lecture.codigo_tipo_adjunto == window._tp.getTypeAttached['survey']) {
                attributes['src'] = window.Misc.urlFull(Route.route('aprende.curso.tema.formulario', {
                    'type': this.model.get('url_tipo_curso'),
                    'category': this.model.get('url_categoria_curso'),
                    'course': this.model.get('url_curso'),
                    'survey': srcVideo
                }));

                this.surveyCompleted(lecture);
            }

            this.$titleCourse.html(model.attributes.nombre_tema_curso);
            this.$descriptionCourse.html(model.attributes.objetivo_tema_curso);
            this.$lectureVideo.html(this.templatePlayer(attributes));

            // reference to video player
            this.$playerVideo = this.$('#player-video-lecture');
            var typeAttachedVideo = [window._tp.getTypeAttached['youtube'], window._tp.getTypeAttached['vimeo']];

            // video player object
            if (_.contains(typeAttachedVideo, attributes['codigo_tipo_adjunto'])) {
                this.player = new MediaElementPlayer(this.$playerVideo[0], {
                    pluginPath: window.Misc.urlFull('js/vendor/'),
                    plugins: ['flash', 'silverlight', 'youtube', 'vimeo'],
                    enablePluginDebug: true,
                    alwaysShowControls: true,
                    videoVolume: 'horizontal',
                    features: ['playpause', 'volume', 'current', 'duration', 'progress', 'fullscreen', 'woopraanalytics'],
                    success: this.readyPlayer
                });
            }

            this.currentLecture = lecture;
            this.currentTheme = model;

            model.trigger('active', model, lecture);
        },

        /**
        * player ready event
        */
        readyPlayer: function(media, element) {
            var _this = this;
            this.listenTo(media, 'trackViewed', this.trackViewed);

            media.addEventListener('ended', function(e) {
                $courseAttachment = new app.CourseThemeAttachedModel();
                $courseAttachment.save({
                    'attached_lecture': _this.currentLecture,
                    'attached_theme': _this.currentTheme
                });
            });
        },

        onPrevVideo: function(event) {
            event.preventDefault();

            var prev = this.courseThemeList.prev(this.currentLecture, this.currentTheme);
            if (_.isObject(prev)) {
                this.changeVideo(prev.lecture, prev.theme);
            }
        },

        onNextVideo: function(event) {
            event.preventDefault();

            var next = this.courseThemeList.next(this.currentLecture, this.currentTheme);
            if (_.isObject(next)) {
                this.changeVideo(next.lecture, next.theme);
            }
        },

        surveyCompleted: function(lecture) {
            if (typeof lecture !== 'undefined' && lecture.codigo_tipo_adjunto == window._tp.getTypeAttached['survey']) {
                this.$lectureVideo.css('display', 'none');
                this.$playerVideo = this.$lectureVideo.find('iframe');
                if (this.$playerVideo.length > 0) {
                    this.$playerVideo.attr('src', lecture.direccion_adjunto + '?completed=true');
                }
            }
        },

        trackViewed: function(media, currentTime, duration) {
            var percent = (currentTime / duration) * 100;
            if (percent > 90) {
                $courseAttachment = new app.CourseThemeAttachedModel();
                $courseAttachment.save({
                    'attached_lecture': this.currentLecture,
                    'attached_theme': this.currentTheme
                });
            }
        }
    });

})(jQuery, this, this.document);
