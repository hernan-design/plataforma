/**
* Class ProfileMentorView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ProfileMentorView = Backbone.View.extend({

		el: '#mentoring-content',
		template: _.template( ($('#mentor-detail-tpl').html() || '') ),
		templateCalendar: _.template( ($('#calendar-mentoring-tpl').html() || '') ),
		templateSessionsCalendar: _.template( ($('#mentoring-session-calendar-list-item').html() || '') ),
		templateAsisstance: _.template( ($('#info-assistance-mentor-tpl').html() || '') ),
		templateExperience: _.template( ($('#info-experience-mentor-tpl').html() || '') ),
		templateExpertise: _.template( ($('#info-expertise-mentor-tpl').html() || '') ),
		templateLevelDev: _.template( ($('#info-level-development-mentor-tpl').html() || '') ),
		templateSocials: _.template( ($('#info-socials-mentor-tpl').html() || '') ),
		templateMainImg: _.template( ($('#main-image-profile-mentor-tpl').html() || '') ),
		events: {
			'click #change-image-mentor-profile': 'onChangeImage',
			'click #recommendation-mentor': 'onRecommendationMentor',
			'click #request-advisory': 'onRequestAdvisory'
		},
		parameters: {
		   //
		},

		/**
		* Constructor Method
		*/
		initialize : function(opts) {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender', 'openModalImg', 'closeModalImg',
			'onEventSelect', 'onEventClick','renderEventEdit','renderEventSchedule', 'renderEventScheduleAdviser',
			'addAllSession', 'addOneSession', 'responseServer', 'loadSpinner');


			this.setElement( this.el );

			// extends parameters
			if( opts.parameters !== undefined && _.isObject(opts.parameters) )
				this.parameters = $.extend({}, this.parameters, opts.parameters);

			//Init Attribute
			this.$modalImageCrop = $('#modal-image-mentor-profile');
			this.$calendarMentoring = $('#calendar-mentoring');
			this.economicsList = new app.PersonEconomicSectorList();
			this.specialitiesList = new app.UserSpecialitiesList();

			this.userProfileModel = new app.UserModel();
			this.recommendationModel = new app.RecommendationModel();
			this.mentoringSessionList = new app.MentoringSessionList();

			this.eventMentoring = new app.EventModel();
			this.eventCalendarModel = new app.EventModel();
			this.scheduleMentoring = new app.ConfirmScheduleMentoringView({ model:this.eventMentoring });
            this.createEventView = new app.UserRequestMentoringView({ model:this.eventCalendarModel });
			this.scheduleAdviser = new app.ScheduleAdviserView({
                model:this.eventMentoring
            });


			this.configAlert = {
				'wrapper': '#main-wrap',
				'closeTime': 6000,
				'speedOpen': 500,
				'speedClose': 500
			};

			this.$modalBase = $('#modal-base-tp');
			this.$modalBaseMaterial = $('#modal-base-message-tp');
			this.$modalAdvisory = $('#modal-request-mentor-advisory');


			var _this = this;
			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

			this.$type = 'encrypt';

			// Events Listener
			this.listenTo( this.model, 'change:id', this.render );
			this.listenTo( this.model, 'change:forma_ayuda_mentoria', this.renderInfoAsisstance );
			this.listenTo( this.model, 'change:experiencia_usuario', this.renderInfoExperience );
			this.listenTo( this.model, 'change:codigo_especialidad', this.renderInfoExpertise );
			this.listenTo( this.model, 'change:stage_mentoring', this.renderInfoLevelDev );
			this.listenTo( this.model, 'change:linkedin_usuario', this.renderInfoSocials );
			this.listenTo( this.model, 'change:imagen_usuario', this.renderMainImage );
			this.listenTo( this.model, 'sync', this.responseServer );
			this.listenTo( this.model, 'request', this.loadSpinner );

			// Sessions Listener
			this.listenTo( this.mentoringSessionList, 'add', this.addOneSession );
            this.listenTo( this.mentoringSessionList, 'reset', this.addAllSession );
            this.listenTo( this.mentoringSessionList, 'request', this.loadSpinner );
            this.listenTo( this.mentoringSessionList, 'sync', this.responseServer );


			// Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );
            this.listenTo( this.scheduleAdviser, 'schedule', this.setScheduleAdviser );
            this.listenTo( this.createEventView, 'addevent', this.createEvent );
            this.listenTo( this.createEventView, 'editevent', this.editEvent );
            this.listenTo( this.createEventView, 'removeevent', this.removeEvent );


			// Change modal title
			this.$modalBase.find('.inner-title-modal').html('Solicitud Mentoria').attr('area-title');
			this.$modalBaseMaterial.find('.inner-title-modal').html('Recomendar Mentor').attr('area-title');
		},

		/*
		* Render View Element
		*/
		render: function() {

			var attributes = this.model.toJSON();
			this.$el.html( this.template(attributes) );

			// Initialize attributes
			this.$wrapperDocuments = this.$('#wrap-documents');

			this.$wrapperData = this.$('#body-sesiones-calendario');

			this.mentoringSessionList.fetch({reset:true});

			// overwrite model id attribute
			if( this.model.changed.id !== undefined ) {

				// Overwrite id attribute of the model
				this.model.idAttribute = 'codigo_usuario';
				this.model.set({'codigo_usuario': this.model.get('codigo_usuario')},{'silent':true});

				// reference to views
				this.referenceViews();
				this.renderMainImage();
				this.renderInfoAsisstance();
				this.renderInfoExperience();
				this.renderInfoExpertise();
				this.renderInfoLevelDev();
				this.renderInfoSocials();
			}
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

			if(window.Misc.checkSession(false)) {
				// call image uploader crop
				 this.setImgUploaderCrop();

				// $(document).on('opened.fndtn.reveal', this.$el, this.scheduleMentoring );

				this.scheduleMentoring;
				// set calendar
				this.setCalendar();


			}

			this.ready();
		},

		/**
		* fires libraries js
		*/
		ready: function () {

			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
				$(document).foundation('dropdown', 'reflow');
				$(document).foundation('tab', 'reflow');
			}

			// reload plugins
			if( typeof(window.initComponent.spinnerTrigger) == 'function' && _.has($.fn, 'spinner') )
				window.initComponent.spinnerTrigger();

			if( typeof(window.initComponent.configSticky) == 'function' && _.has($.fn, 'sticky') )
				window.initComponent.configSticky();

			// reload plugins
			if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
				window.initComponent.chosenTrigger();

			if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
				window.initComponent.select2Trigger();

			if( typeof window.initComponent.initConfigForm == 'function' )
				window.initComponent.initConfigForm();
		},

		/**
		* reference to views
		*/
		referenceViews: function () {

			// Instance edit project view
			this.editMentor = new app.EditMentor({
				el: this.$el,
				model: this.model,
				parameters: {
					'economics': this.economicsList,
					'specialities': this.specialitiesList,
					'user': this.model.get('codigo_usuario'),
					'person': this.model.get('codigo_persona'),
					'owner': this.model.get('owner')
				}
			});

			// EconomicSector
			this.economicsList.fetch({
				data: {codigo_persona: this.model.get('codigo_persona')},
				reset: true
			});

			// Specialities
			this.specialitiesList.fetch({
				data: {codigo_usuario: this.model.get('codigo_usuario')},
				reset: true
			});

			// Instance of Documents of Advice
            this.mentorAttachments = new app.MentorAttachments({
                el: this.$wrapperDocuments,
                model: this.model,
                parameters: {
                    //
                }
            });


			this.mentorAttachments.render();
			var attributes = {};
			attributes.codigo_proyecto = this.codigo_proyecto;

			  this.$calendarMentoring = this.$('#calendar-mentoring');
			if( this.editMentor )
				this.editMentor.render();

		},


		/**
		 * Render all view of Sessions
		 */
        addAllSession: function() {
            this.$wrapperData.html('');
 
            this.mentoringSessionList.forEach( this.addOneSession, this );
		},

		/**
		 *  render session item
		 * @param {} mentoringModel
		 */
		addOneSession: function (mentoringModel) {
			$( ".yourSessions" ).remove();
			this.$wrapperData.append(this.templateSessionsCalendar(mentoringModel.toJSON()));

            // // refresh plugins
            this.ready();
        },

		// ==============================================
		//           start calendar
		// ==============================================
		setCalendar: function () {
            var _this = this;

            this.$calendarMentoring.fullCalendar({
                header: {
                  left: 'prevYear, prev,next, nextYear today',
                  center: 'title',
                  right: 'month,agendaWeek,agendaDay'
                },
                lang: 'es',
                defaultDate: moment(),
                defaultView: 'month',
                selectable: true,
                editable: true,
                dragOpacity: .75,
                weekNumbers: false,
				aspectRatio: 650/300,
				contentHeight: 'auto',
				eventSources: [
                    {
                        url: window.Misc.urlFull( Route.route('calendario.evento.index') ),
                        type: 'GET',
                        data: {
							'type': 'schedule',
							'event':'mentoring',
                            'codigo_usuario': _this.model.get('codigo_usuario')
                        },
                        error: function (jqXHR, status, error) {
                            console.log('error::', status, error);
                        },
                        success: this.successRequetsEvents,
                        editable: true
                    }
                ],
                select: this.onEventSelect,
                eventClick: this.onEventClick
			});

			if( this.$calendarMentoring.data('fullCalendar') !== undefined )
				this.$calendarMentoring.fullCalendar('render');
		},



	 /**
        * response of events
        * @param Object resp
        */
	   successRequetsEvents: function () {
		// body...
		},

		/**
        * handler zone selected on calendar
        */
	   onEventSelect: function  ( start, end, jsEvent, view ) {
		var calendar = this.$calendarMentoring.fullCalendar('getCalendar'),
			attrsEvent = {
				start: calendar.moment(start).format('YYYY-MM-DD HH:mm'),
				end: calendar.moment(end).format('YYYY-MM-DD HH:mm'),
				now: calendar.moment().format('YYYY-MM-DD HH:mm')
			};

			var owner =  this.model.get('owner');


		if( owner && attrsEvent['now'] < attrsEvent['end'])
		{
			this.renderEventEdit(attrsEvent);
		}

	},


        /**
        * handler event click on calendar
        * @param Object calEvent
        * @param Object jsEvent
        * @param Object view
        */
	   onEventClick: function  (calEvent, jsEvent, view) {
		var calendar = this.$calendarMentoring.fullCalendar('getCalendar'),
			attrsSchedule = {
				start: calendar.moment( calEvent.start ).format('MMMM Do YYYY, h:mm:ss a'),
				end: calendar.moment( calEvent.end ).format('MMMM Do YYYY, h:mm:ss a'),
				stateEvent: _.find(calEvent.className, function (eventClasses) {
					return eventClasses == 'available' || eventClasses == 'confirm' || eventClasses == 'confirmed' || eventClasses == 'unregistered';
				})
			};

		if( calEvent.className.indexOf('available') !== -1 && calEvent.className.indexOf('disabled') === -1  && typeof(calEvent.owner) !== 'undefined' && calEvent.owner && calEvent.clase_tipo_evento == window._tp.getClassTypeEvent['user']){
			_.extend(attrsSchedule, {
				start: calendar.moment( calEvent.start ).format('YYYY-MM-DD HH:mm'),
				end: calendar.moment( calEvent.end ).format('YYYY-MM-DD HH:mm')
			});
			this.renderEventEdit(attrsSchedule, calEvent);

		}else if( calEvent.codigo_evento !== undefined && calEvent.className.indexOf('disabled') === -1 ){
			this.renderEventScheduleAdviser(attrsSchedule, calEvent);
		}
		else if( calEvent.className.indexOf('disabled') === -1 ){
			this.renderEventSchedule(attrsSchedule, calEvent);
		}
	},

	  /**
        * render calendar schedule mentoring
        */
	   scheduleMentoring: function  () {
		// render calendar
		if( this.$calendarMentoring.data('fullCalendar') !== undefined ){
			this.$calendarMentoring.fullCalendar('render');
		}
	},

	renderEventEdit: function (attrsEvent, calEvent) {
		attrsEvent || (attrsEvent = {});
		calEvent || (calEvent = {});
		this.createEventView.attrsEvent = attrsEvent;
		this.createEventView.calEvent = calEvent;
		this.eventCalendarModel.resetAttrs({silent:true});

		if(  !_.isUndefined(calEvent) && !_.isEmpty(calEvent) &&  !_.isUndefined(calEvent.codigo_evento) ){
			this.eventCalendarModel.set('codigo_evento', calEvent.codigo_evento);
			this.eventCalendarModel.fetch({data: {type:this.$type , processData: true}});
			this.createEventView.render();
		}else{
			this.createEventView.render();
		}

		this.createEventView.$el.dialog('open');
	},

	renderEventSchedule: function (attrsSchedule, calEvent) {
		attrsSchedule || (attrsSchedule = {});
		calEvent || (calEvent = {});

		this.scheduleMentoring.attrsSchedule = attrsSchedule;
		this.scheduleMentoring.calEvent = calEvent;
		this.eventMentoring.resetAttrs({silent:true});
		this.eventMentoring.set('codigo_evento', calEvent.codigo_evento);
		this.eventMentoring.fetch({data: {type:this.$type , processData: true}});

		this.scheduleMentoring.$el.dialog('open');
	},

	renderEventScheduleAdviser: function (attrsSchedule, calEvent) {
		attrsSchedule || (attrsSchedule = {});
		calEvent || (calEvent = {});
		var type = 'encrypt';
		this.scheduleAdviser.attrsSchedule = attrsSchedule;
		this.scheduleAdviser.calEvent = calEvent;
		this.eventMentoring.resetAttrs({silent:true});
		this.eventMentoring.set('codigo_evento', calEvent.codigo_evento );
		this.eventMentoring.fetch({data: {type:type , processData: true}});
		this.scheduleAdviser.render();
		this.scheduleAdviser.$el.dialog('open');
	},




		// ==============================================
		//           start image uploader and crop
		// ==============================================

		/**
		* set image uploader crop
		*/
		setImgUploaderCrop: function () {

			var _this = this;

			this.$el.imageUploaderCrop({
				formCrop: $('#form-mentor-profile-crop'),
				imgCrop: $('#image-mentor-profile-tocrop'),
				previewImg: $('#mentor-profile-preview-tocrop'),
				uploaderImg: $('#uploader-image-mentor-profile'),
				templateImgUploader: 'qq-img-uploader-template',
				configImg: {
					maxWidthImg : 240 * 4,
					maxHeightImg : 240 * 4,
					minWidthImg : 240,
					minHeightImg : 240
				},
				uploadding: {
					inputName: 'file',
					endpoint: document.url + Route.route('file.temp'),
					customHeaders: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
						'X-XSRF-TOKEN': window.Misc.getCsrf().getCookie('XSRF-TOKEN')
					},
					params: {
						'_token': $('meta[name="csrf-token"]').attr('content')
					}
				},
				cropping: {
					endpoint: document.url + Route.route('file.crop'),
					params: {}
				},
				extraDropzones: [/*this.$('#project-main-image'),*/ $('#image-crop-mentor-profile')],
				// Events handlers
				callbacks: {
					onLoadImg: function ($uploaderImg, id, name) {

						var $areaDrop = $uploaderImg.fineUploader('getDropTarget', id);

						if( $areaDrop !== undefined && $areaDrop.length ){
							if( $areaDrop.hasClass('image-area-drop') ){

								$(document).on('closed.fndtn.reveal', _this.$modalImageCrop, _this.closeModalImg);
								_this.$modalImageCrop.foundation('reveal', 'open');
							}
						}

						window.Misc.setSpinner( _this.$modalImageCrop.find('.content-modal') );
					},
					onCompleteLoad: function ($uploaderImg, id, name, res) {
						$uploaderImg.find('.qq-uploader').css( {'border': 'none'} );

						window.Misc.removeSpinner({
							'wrap': _this.$modalImageCrop,
							'direct': false
						});
					},
					onCropping: function (jcrop_img) {
						window.Misc.setSpinner( _this.$modalImageCrop.find('.content-modal') );
					},
					onCropComplete: function (jcrop_img, resp, jqXHR) {
						// response success or error
						var confCrop = {},
							type = resp.success ? 'success' : 'alert',
							text = resp.success ?
								(resp.message !== undefined ? resp.message : '')
								: resp.errors;

						if( _.isObject( resp.errors ) ){

							var listError = '<ul>';

							$.each(resp.errors, function(field, item) {
								 listError += '<li>'+ item[0] +'</li>';
							});
							listError += '</ul>';

							text = listError;
						}

						var conf = {
							wrapper: _this.$modalImageCrop.find('.content-modal'),
							text: text,
							type: type
						};
						confCrop = $.extend({}, _this.configAlert, conf);


						if( resp.success !== undefined ) {
							if( resp.success ){

								_this.model.save({'imagen_usuario': resp.file_path}, {
									patch: true,
									wait: true
								});

								_this.$modalImageCrop.foundation('reveal', 'close');
							}else{
								window.Misc.showAlertBox( confCrop );
							}
						}

						window.Misc.removeSpinner({
							'wrap': _this.$modalImageCrop,
							'direct': false
						});
					},
					onCropError: function (jcrop_img, jqXHR, error) {
						var confCrop = {},
							conf = {
								wrapper: _this.$modalImageCrop.find('.content-modal'),
								text: 'La imagen no puede ser ajustada.',
								type: 'alert',
								close: true
							};

						confCrop = $.extend({}, _this.configAlert, conf);

						window.Misc.removeSpinner({
							'wrap': _this.$modalImageCrop,
							'direct': false
						});
						window.Misc.showAlertBox( confCrop );
					}
				},
                messages: window._tp.messages
			});
		},

		/**
		* change project image main
		*/
		onChangeImage: function (e) {

			if( e !== undefined )
				e.preventDefault();

			this.$modalImageCrop.on('opened', this.openModalImg);
			$(document).on('closed.fndtn.reveal', this.$modalImageCrop, this.closeModalImg);

			this.$modalImageCrop.foundation('reveal', 'open');
		},

		/**
		* handler event with avatar modal is opened
		*/
		openModalImg: function (e) {

			var _this = this;

			if( this.$el.data('imageUploaderCrop') !== undefined )
				this.$el.imageUploaderCrop('changeImage', this.model.get('imagen_usuario'));
		},

		/**
		* handler event on crop modal is closed
		*/
		closeModalImg: function (e) {

			if(e.namespace != 'fndtn.reveal') return;

			var $imgCrop = this.$el.imageUploaderCrop('getImgCrop'),
				jcrop_img = null;

			// check out if already was assigned the jcrop library
			if( $imgCrop.data('Jcrop') !== undefined ){
				jcrop_img = $imgCrop.data('Jcrop');
				jcrop_img.destroy();
			}

			// detach events
			this.$modalImageCrop.off('opened');
			$(document).off('closed.fndtn.reveal');
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
		* render main image
		*/
		renderMainImage: function (model, value, opts) {

			this.$('#mentor-profile-main-image').html( this.templateMainImg( this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info asisstance
		*/
		renderInfoAsisstance: function (model, value, opts) {

			this.$('#mentor-asisstance-container .content-assistance-mentoring').removeClass('editing').html( this.templateAsisstance(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info experience
		*/
		renderInfoExperience: function (model, value, opts) {
			this.$('#mentor-experience-container .content-experience-mentor').removeClass('editing').html( this.templateExperience(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info Expertise
		*/
		renderInfoExpertise: function (model, value, opts) {

			this.$('#mentor-expertise-container').html( this.templateExpertise(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info Level Development
		*/
		renderInfoLevelDev: function (model, value, opts) {

			this.$('#mentor-level-development-container').html( this.templateLevelDev(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info Socials
		*/
		renderInfoSocials: function (model, value, opts) {
			this.$('#mentor-socials-container').html( this.templateSocials(this.model.toJSON()) );
			this.ready();
		},

		/**
        * listen when adviser was scheduled
        */
	   setScheduleAdviser: function () {
            this.$calendarMentoring.fullCalendar('removeEvents');
			this.$calendarMentoring.fullCalendar('refetchEvents');
        },

         /**
        * create event on calendar
        */
       createEvent: function (calEvent) {
            calEvent || (calEvent = {});
            this.$calendarMentoring.fullCalendar('renderEvent', calEvent, true);
            this.$calendarMentoring.fullCalendar('removeEvents');
			this.$calendarMentoring.fullCalendar('refetchEvents');
        },

        /**
        * edit event on calendar
        */
        editEvent: function  (calEvent) {
            calEvent || (calEvent = {});
            this.$calendarMentoring.fullCalendar('updateEvent', calEvent);
            this.$calendarMentoring.fullCalendar('removeEvents');
			this.$calendarMentoring.fullCalendar('refetchEvents');
        },

        /**
        * remove event on calendar
        */
        removeEvent: function (idEvent) {
            this.$calendarMentoring.fullCalendar('removeEvents', idEvent);
            this.$calendarMentoring.fullCalendar('removeEvents');
			this.$calendarMentoring.fullCalendar('refetchEvents');
        },

		/**
		* Event request mentoring
		*/
		onRecommendationMentor: function (e) {

			if( e !== undefined)
				e.preventDefault();

			// Reference to view recommendation mentor
			if ( this.recommendationMentorView instanceof Backbone.View ){
				this.recommendationMentorView.stopListening();
				this.recommendationMentorView.undelegateEvents();
				this.recommendationMentorView.remove();
			}

			this.recommendationMentorView = new app.RecommendationMentorView({
				model: this.recommendationModel,
				parameters: {
					type: 'mentor',
					institution: this.model.get('institucion')
				}
			});

			this.$modalBaseMaterial.find('.inner-title-modal').html( $(e.currentTarget).attr('area-title') ).removeClass('text-center');
			this.$modalBaseMaterial.find('.content-modal').html( this.recommendationMentorView.render().el );
			this.$modalBaseMaterial.foundation('reveal', 'open');
        },


		/**
		* Event request mentoring
		*/
		onRequestAdvisory: function (e) {

            if( e !== undefined)
            e.preventDefault();
            e.stopImmediatePropagation();

            // Reference to view requestAdvisory
			if ( this.requestAdvisory instanceof Backbone.View ){
				this.requestAdvisory.stopListening();
				this.requestAdvisory.undelegateEvents();
				this.requestAdvisory.remove();
			}

			this.requestAdvisory = new app.RequestAdvisoryView({
				model: this.model,
				parameters: {
				   //
				}
            });


           // this.$modalBase.find('.inner-title-modal').html( $(e.currentTarget).attr('area-title') ).removeClass('text-center');
            this.$modalAdvisory.find('.content-modal').html( this.requestAdvisory.render().el );
            this.$modalAdvisory.foundation('reveal', 'open');

		}


   });

})(jQuery, this, this.document);
