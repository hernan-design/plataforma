/**
* Class CourseContentView of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.CourseContentView = Backbone.View.extend({
		el: '#course-content',
		template: _.template( ($('#course-contentcourse-tpl').html() || '') ),
        template_navbar: _.template( ($('#learn-navbar-button').html() || '') ),
		events: {
			'click .on-unsubscribe-course': 'onUnsubscribe',
			'click .course-certificate' : 'onCertificate'
		},

		/**
		* Constructor Method
		*/
		initialize: function(){
			_.bindAll(this, 'beforeRender', 'render', 'afterRender');

            // Init Attributes
            this.courseThemeList = new app.CourseThemeList();
            this.discussionList = new app.DiscussionList();
            this.registrationCourseList = new app.RegistrationCourseList();
			this.registrationcourseModel = new app.RegistrationCourseModel();

			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
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
			this.listenTo( this.registrationcourseModel, 'destroy', this.removeRegistration );
		},

		/*
		* Render View Element
		*/
		render: function(){
			var attributes = this.model.toJSON(),
				_this = this;

			if( _.isObject(this.attributes) && this.attributes.type !== undefined ){
				attributes.type = this.attributes.type;
			}

            this.$el.html( this.template_navbar(attributes) );
			this.$el.append( this.template(attributes) );

			//Init Attributes
			this.$wrapperDiscussion = this.$('#wrapper-course-discussion');
			this.$wrapperUserRegistration = this.$('#side-course-students');

			// init reference to sections
			this.referenceToSections();

			this.courseThemeList.fetch( {data: {'course': this.model.get('url_curso'), 'content': true}, reset:true} );
			return this;
		},

		/**
		* instance to sections
		*/
		referenceToSections: function () {
			// instance of themes view
			this.courseThemeListView = new app.CourseThemeListView({
				el: this.$('.content-themes-course'),
				collection: this.courseThemeList,
				attributes: {
					'type': this.attributes.type,
					'viewTheme': 'CourseThemeItemView',
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
					// 'viewDiscussion': 'DiscussionPostView',
					// 'viewDiscussionComment': 'CourseDiscussionCommentView'
				}
			});

			// instance of user registration course view
			this.userRegistrationListView = new app.UserRegistrationListView({
				el: this.$wrapperUserRegistration,
				collection: this.registrationCourseList,
				parameters: {
					'course': this.model.get('url_curso')
				}
			});

			this.confirmUnsubscribe = new app.CourseUnsubscribeConfirmView({
				model:this.registrationcourseModel,
				parameters: {
				   'titleConfirm' : '¿Estás seguro que quieres abandonar este curso?',
				   'inscripcion' : this.model.get('inscripcion'),
				   'course' : this.model.get('url_curso')
				}
			});
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function() {
            //
		},

		/**
		* Fires after of run render function
		*/
		afterRender: function() {
			this.ready();
		},

		/**
		* fires libraries js and functions
		*/
		ready: function () {
			// trigger libraries
			if(_.has($.fn, 'foundation')) {
				this.$el.foundation('abide');
				$(document).foundation('tab', 'reflow');
				$(document).foundation('tooltip', 'reflow');
			}
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
		 * Generate Certificate
		 */
		onCertificate: function(e) {
			e.preventDefault();

			var course = this.model.get('codigo_curso'),
			_this = this;

			window.Misc.setSpinner( this.$el );

			$.post( window.Misc.urlFull( Route.route('aprende.curso.certificado') ), {
                '_token': $('meta[name=csrf-token]').attr('content'),
                data: course
            }).success( function (resp){
				if (resp.success) {
					window.Misc.removeSpinner({
						'wrap': _this.$el,
						'direct': true
					});

					window.Misc.redirect(resp.url)
				} else {
					var config = {
						'text': resp.error,
						'type': 'alert'
					};
					_.extend( _this.configAlert, config );

					window.Misc.showAlertBox( conf );
				}
			});
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
		removeRegistration: function (model, opts) {
			// Redirect to Content Course
			url = Route.route('aprende.categoria.curso' , { 'type': this.attributes.type, 'category': this.model.get('url_categoria_curso'), 'course': this.model.get('url_curso') }) ;
			Backbone.history.navigate(url, { trigger:true });
		}

   });

})(jQuery, this, this.document);
