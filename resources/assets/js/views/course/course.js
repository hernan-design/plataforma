/**
* Class CourseView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.CourseView = Backbone.View.extend({

        el: '#course-content',
        template: _.template( ($('#course-detail-tpl').html() || '') ),
        template_navbar: _.template( ($('#learn-navbar-button').html() || '') ),
        events: {
            'click .register-course': 'onStore',
            'click .on-unsubscribe-course': 'onUnsubscribe',
        },

        /**
        * Constructor Method
        */
        initialize : function() {

            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

            this.registrationcourseModel = new app.RegistrationCourseModel();


            this.$modalConfirm = $('#modal-base-confirm-tp');

            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

            // Init Attribute
            this.likeList = new app.LikeList();
            this.courseThemeList = new app.CourseThemeList();
            this.courseThemeListView = new app.CourseThemeListView( {
                collection: this.courseThemeList,
                attributes: {
                    'type': this.attributes.type,
                    'viewTheme': 'CourseThemesView',
                }
            });


            this.configAlert = {
                'wrapper': this.$el,
                'closeTime': 7000,
                'speedOpen': 500,
                'speedClose': 500
            };

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );

            this.listenTo( this.registrationcourseModel, 'change', this.render );
            this.listenTo( this.registrationcourseModel, 'sync', this.responseServerRegistration );
            this.listenTo( this.registrationcourseModel, 'destroy', this.removeRegistration );

            this.model.fetch();
        },

        /*
        * Render View Element
        */
        render: function() {


            var attributes = this.model.toJSON();
            if( _.isObject(this.attributes) && this.attributes.type !== undefined ){
                attributes.type = this.attributes.type;
            }
            this.$el.html( this.template_navbar(attributes) );
            this.$el.append( this.template(attributes) );
            this.$likeLink = this.$('.data-post-share.TPlikelink');
            this.$countLikes = this.$('.data-count-likes');
            this.onLikeCourse();
            //Init Attributes
            this.$moreAboutCourse = this.$('.wrap-about-course.container-more');
            this.confirmUnsubscribe = new app.CourseUnsubscribeConfirmView({
                model:this.registrationcourseModel,
                parameters: {
                   'titleConfirm' : '¿Estás seguro que quieres abandonar este curso?',
                   'inscripcion' : this.model.get('inscripcion'),
                   'course' : this.model.get('url_curso')
                }
            });

            // overwrite attribute id of the model
            if( this.model.changed.codigo_curso ){
                this.model.idAttribute = 'codigo_curso';
                this.model.set({'codigo_curso':this.model.get('codigo_curso')}, {'silent':true});
            }

            // link show more
            window.Misc.showMore({'container': this.$moreAboutCourse, 'maxlen': 300});

            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('tab', 'reflow');
            }

            // Init Attributes
            this.$buttonRegistration = this.$('.register-course');
            this.courseThemeList.fetch( {data: {'course': this.model.get('url_curso'), 'content': true }, reset:true} );
            return this;
        },

        /**
        * Fires before of run render function
        */
        beforeRender: function () {
            // body...
        },

        /**
        * Fires after of run render function
        */
        afterRender: function () {

            var _this = this;
            // reflow foundation plugins
            if( _.has($.fn, 'foundation') ){
                this.$el.foundation('abide');
                $(document).foundation('dropdown', 'reflow');
            }

            // to fire plugins
            if( typeof window.initComponent.configSticky == 'function' )
                window.initComponent.configSticky();

            if( typeof window.initComponent.configScrollbar == 'function' )
                window.initComponent.configScrollbar();
        },

        /**
        * destroy event
        */
        onUnsubscribe: function (e) {
            e.preventDefault();

            this.registrationcourseModel.set('codigo_usuario', this.model.get('codigo_usuario'), {silent:true});
            this.confirmUnsubscribe.render();
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

        /**
        * Event for register course
        */
        onStore: function (e) {
            e.preventDefault();

            var data = { 'codigo_curso': this.model.get('codigo_curso'), '_token': $('meta[name="csrf-token"]').attr('content') };

            this.registrationcourseModel.save( data, {patch: true, wait:true} );
            this.$buttonRegistration.addClass('disabled');
        },

        /**
        * response of the server model registrationCourse
        */
        responseServerRegistration: function ( model, resp, opts ) {
            // response success or error
            var type = resp.success ? 'success' : 'alert',
                text = resp.success ?
                    (resp.message !== undefined ? resp.message : '...')
                    : resp.errors;
            if( _.isObject( resp.errors ) ){
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
            _.extend( this.configAlert, config );
            this.$buttonRegistration.removeClass('disabled');
            if( resp.success ){
                if(resp.inscripcion){
                    // Redirect to Content Course
                    url = Route.route('aprende.contenido', {type: this.attributes.type, category: this.model.get('url_categoria_curso'), course: this.model.get('url_curso') }) ;
                    // url = window.Misc.urlFull( Route.route('aprende.contenido', {type: this.attributes.type, category: this.model.get('url_categoria_curso'), course: this.model.get('url_curso') }) );
                    Backbone.history.navigate(url, { trigger:true });
                    // window.Misc.redirect(url);
                }
            }else{
                window.Misc.showAlertBox( this.configAlert );
            }
        },
         /**
        * Event for register course
        */
        removeRegistration: function (model, opts) {
            this.model.set('inscripcion', false);
        },
        onLikeCourse: function() {
            this.likeLinkView = new window.app.LikeView({
                el: this.$likeLink,
                collection: this.likeList,
                attributes: {
                    'data-srcparams': this.model.get('srcparams')
                }
            });
            this.likeLinkView.$countLikes = this.$countLikes;
        }
   });
})(jQuery, this, this.document);
