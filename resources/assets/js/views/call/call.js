/**
* Class CallView extends of Backbone View
* @author TuProyecto || Desarrollador : @dropecamargo
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.CallView = Backbone.View.extend({

		el: '#calls-content',
		template: _.template( ($('#call-detail-tpl').html() || '') ),
		templateCountdown: _.template( ($('#-').html() || '') ),
        templateTop: _.template( ($('#programs-menu').html() || '') ),
		events: {
			'click #link-join-call': 'onToJoin',
            'click #onBack': 'onBack',
			'click .program-shared-list .show-user-likes': 'onShowUserLikes',
			'click .show-participants-program': 'onShowParticipantsProgram',
            'submit .phase-resource-finalize-form':'onFinalizePhaseResource'
		},
		parameters: {
			oldView: null
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender');

			if( opts !== undefined && _.isObject(opts.parameters) )
				this.parameters = $.extend({}, this.parameters, opts.parameters);

			if( this.parameters.oldView instanceof Backbone.View )
				this.stopCountdown( this.parameters.oldView.intervalCount );

			// Init Attributes
			this.stageUserModel = new app.CallStageUserModel();
			this.likeList = new app.LikeList();
			this.discussionList = new app.DiscussionList();
			this.faqProgramList = new app.FaqProgramList();


			this.$modalBase = $('#modal-base-tp');
			this.$modalBase.addClass('not-fixed');
			this.$modalBaseMaterial = $('#modal-base-material');




            var _this = this;
            this.render = _.wrap(this.render, function(render) {

                _this.trigger('beforeRender');

                render();

                _this.trigger('afterRender');

                return _this;
            });

			this.configAlert = {
				'wrapper': this.$el,
				'closeTime': 8000,
				'speedOpen': 500,
				'speedClose': 500
			};

			// Events Listener
			this.listenTo( this.model, 'change', this.render );
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
		},

		/*
		* Render View Element
		*/
		render: function() {
			var attributes = this.model.toJSON();


            this.$el.html( this.templateTop() );
            this.$el.append( this.template(attributes) );
			// Initialize attributes
			this.$wrapperDiscussion = this.$('#wrapper-program-discussion');
            this.$wrapperFaq = this.$('#faq-programs');
			this.$modalLogin = $('#modal-login');
			this.$likeLink = this.$('.data-post-share.TPlikelink');
			this.$countLikes = this.$('.data-count-likes');


			 // Redefine id attribute model
			if( this.model.changed.codigo_convocatoria !== undefined ) {
				// Overwrite id attribute of the model
				this.model.idAttribute = 'codigo_convocatoria';
				this.model.set({'codigo_convocatoria': this.model.get('codigo_convocatoria')},{'silent':true});

				$(window).scrollTop(0);
			}

			if (this.model.get('codigo_convocatoria')) {
				// reference to views
				this.referenceViews();
			}

			// Change modal title
			this.$modalBase.find('.inner-title-modal').html( this.$('#link-join-call').attr('area-title') );
			this.$modalBaseMaterial.find('.content-modal').addClass('scroll-user-likes');

			// Reload plugins function
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
				$(document).foundation('tab', 'reflow');
				$(document).foundation('dropdown', 'reflow');
			}

			// Fire puglin libraries
			if( typeof window.initComponent.configScrollbar == 'function' && _.has($.fn, 'perfectScrollbar') )
				window.initComponent.configScrollbar();

			if( typeof window.initComponent.configSlick == 'function' && _.has($.fn, 'slick') )
				window.initComponent.configSlick();

			// set countdown
			if( !this.model.get('permanente_convocatoria') ) this.setCountdown();

			return this;
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

        },

		/**
		* set closing countdown
		*/
		setCountdown: function () {
			// Set countdown closed program

			// Countdown close program
			var currentDate = window.moment(),
				closingDate = window.moment([this.model.get('fecha_cierre_registro') || currentDate.format('YYYY-MM-DD'), '23:59:59'].join(' '), "YYYY-MM-DD HH:mm:ss"),
				diff = closingDate.diff( currentDate ),
				duration = window.moment.duration( diff ),
				interval = 1000;

			// console.log( window.moment.duration(duration.asDays(), 'days').format('DD'), currentDate, closingDate, this.model.get('fecha_cierre_registro') );

			if( !closingDate.isValid() || !this.model.get('opened') ){

				// overwrite time
				_.extend(duration, {
					days: function () { return 0; },
					hours: function () { return 0; },
					minutes: function () { return 0; },
					seconds: function () { return 0; }
				});

			    this.$('.countdown-program-closing').addClass('closed')
			    									.html( this.templateCountdown({countdown:duration}) );
			    duration = false;
			}else {
				this.$('.countdown-program-closing').removeClass('closed')
													.html( this.templateCountdown({countdown:duration}) );
			}

			this.intervalCount = setInterval(function() {

				if( !window.moment.isDuration(duration) || duration.asMilliseconds() <= 0 ){
					this.stopCountdown(this.intervalCount);
					return;
				}

				duration = window.moment.duration(duration - interval, 'milliseconds');

				this.$('.countdown-program-closing').html( this.templateCountdown({countdown:duration}) );

			}.bind(this), interval);
		},

		/**
		* stop closing countdown
		*/
		stopCountdown: function (countdown) {
			clearInterval(countdown);
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
		* show user likes
		*/
		onShowUserLikes: function (e) {
			e.preventDefault();

			// to render view user likes
			this.viewUserLikes = new window.app.UserLikesListView({
				attributes: {
					'data-srcparams': this.model.get('srcparams')
				}
			});

			this.$modalBase.find('.inner-title-modal').html( 'Personas a las que les gusta esto' );
			this.$modalBase.find('.content-modal').html( this.viewUserLikes.render().el );
			this.$modalBase.find('.content-modal').append( this.viewUserLikes.$wrapViewMore );

			this.$modalBase.foundation('reveal','open');
		},

		/**
		* show participants Program
		*/
		onShowParticipantsProgram: function (e) {

			e.preventDefault();

			if ( this.participantsProgramUserListView instanceof Backbone.View ){
				 this.participantsProgramUserListView.stopListening();
				 this.participantsProgramUserListView.undelegateEvents();

			}
			// to render view participants user
			this.participantsProgramUserListView = new window.app.ParticipantsProgramUserListView({
				parameters: {
					'program': this.model.get('url_convocatoria'),
					'orientacion': this.model.get('codigo_orientacion_convocatoria')
				}
			});

			this.$modalBaseMaterial.addClass('small');
			this.$modalBaseMaterial.find('.inner-title-modal').html( 'Participantes en esta Convocatoria' );
			this.$modalBaseMaterial.find('.content-modal').html( this.participantsProgramUserListView.render().el );
			this.$modalBaseMaterial.find('.content-modal').append( this.participantsProgramUserListView.$wrapViewMore );

			this.$modalBaseMaterial.foundation('reveal','open');
		},

		/**
		* Event join to call
		*/
		onToJoin: function (e) {

			e.preventDefault();

			if( window.Misc.checkSession(false) ) {
				var applyToUser = new app.ApplyToUserView( {
					model:this.stageUserModel,
					parameters: {
						'codigo_convocatoria': this.model.get('codigo_convocatoria'),
						'orientacion': this.model.get('codigo_orientacion_convocatoria'),
						'userentitys':this.model.get('userentitys')
					}

				} );
				applyToUser.codigo_convocatoria = this.model.get('codigo_convocatoria');
				applyToUser.codigo_orientacion_convocatoria = this.model.get('codigo_orientacion_convocatoria');
				this.$modalBase.addClass('small');
				this.$modalBase.find('.inner-title-modal').html( '¡Participa en esta convocatoria!' );

				this.$modalBase.find('.content-modal').html( applyToUser.render().el );
				applyToUser.ready();

				this.$modalBase.foundation('reveal', 'open');
			}else{
				this.$modalLogin.foundation('reveal','open');
			}

		},

        /**
         * show user likes
         */
        onFinalizePhaseResource: function (e) {
             e.preventDefault();

             var form = $(e.currentTarget);
             this.loadSpinner();
            _this = this;

            //Make Ajax Call
            Backbone.ajax({
                dataType: "json",
                method: "POST",
                url:   window.Misc.urlFull(Route.route( 'convocatoria.fase.adjunto.store') ),
                data: form.serializeArray(),
                success: function(data){
                    //code after success
                    if(data.success !== undefined && data.success)
                    {
                        btn = $('.phase-resource-finalize-btn');
                        btn.attr('disabled', 'disabled');
                        btn.removeClass('phase-resource-finalize-btn inst-secondary-outline is-hovered');
                        btn.empty();
                        btn.append('<i class="mdi mdi-check gutter-right mdi-16"></i>Has finalizado esta fase');
                        btn.parent().append('<small>* Has finalizado esta fase</small>');
                    }


                },
                complete:function(data){

                    window.Misc.removeSpinner({
                        'wrap': _this.$el,
                        'direct': true
                    });
                }

            });
        },

		/**
		* reference to views
		*/
		referenceViews: function () {
			if (this.discussionListView instanceof Backbone.View) {
				this.discussionListView.stopListening();
				this.discussionListView.undelegateEvents();
			}
			// instance of discussion view
			this.discussionListView = new app.DiscussionListView({
				el: this.$wrapperDiscussion,
				collection: this.discussionList,
				parameters: {
                    'formDiscussion': '#form-discussion-program',
                    dataFilter: {
                        'codigo_recurso_modulo': this.model.get('codigo_convocatoria'),
                        'codigo_modulo': window._tp.getModule('calls')
                    }
				}
			});

			// intance of faqProgram view
			this.faqProgramListView = new app.FaqProgramListView({
				el: this.$wrapperFaq,
				collection: this.faqProgramList,
				parameters: {
					'program': this.model.get('url_convocatoria')
				}
			});

			// likes
			this.likeLinkView = new window.app.LikeView({
				el: this.$likeLink,
				collection: this.likeList,
				attributes: {
					'data-srcparams': this.model.get('srcparams')
				}
			});
			this.likeLinkView.$countLikes = this.$countLikes;
		},
		onBack: function(e){
		    e.preventDefault();
		    history.back(1);
        }
   });

})(jQuery, this, this.document);
