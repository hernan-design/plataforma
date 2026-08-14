/**
* Class EventView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.EventView = Backbone.View.extend({

        el: '#calendar-content',
        templateDate: _.template( ($('#event-date-tpl').html() || '') ),
        templateCity: _.template( ($('#event-city-tpl').html() || '') ),
		templateTitle: _.template( ($('#event-title-tpl').html() || '') ),
        template: _.template( ($('#calendar-event-detail-tpl').html() || '') ),
        templateInscribed: _.template( ($('#inscribed-event-tpl').html() || '') ),
		templateDescription: _.template( ($('#info-description-event-tpl').html() || '') ),
        events: {
            'click #change-photo-user': 'onChangeImage'
        },

        /**
        * Constructor Method
        */
        initialize: function(){
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'openModalImg', 'closeModalImg');

            var _this = this;

			this.render = _.wrap(this.render, function(render) {

				_this.trigger('beforeRender');

				render();

				_this.trigger('afterRender');

				return _this;
			});

            // Init attributes
            this.$modalImageCrop = $('#modal-image-event');
            this.$modalBaseMaterial = $('#modal-base-material');

            // Init model
            this.modelEventUser = new app.UserEventModel();

            // Init collection
            this.usersEventList = new app.UsersEventList();

            // Events Listener
            this.listenTo( this.model, 'change', this.render );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'change:nombre_evento', this.renderEventTitle );
            this.listenTo( this.model, 'change:codigo_ciudad', this.renderEventCity );
            this.listenTo( this.model, 'change:fecha_evento', this.renderEventDate );
			this.listenTo( this.model, 'change:descripcion_evento', this.renderInfoDescription );

            // Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function () {

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            // init wrapper
            this.$btnViewParts = this.$('.all-participants');
            this.$wrapEventUser = this.$('#participate-event');
            this.$wrapEventUserList = this.$('#event-participants-list');

            this.$btnViewParts.css('display', 'none');

            // edit fields
            this.referenceViews();
            this.renderEventCity();
            this.renderEventDate();
            this.renderEventTitle();
            this.renderUsersEvent();
            this.renderInfoDescription();
            this.renderButtonParticipate();

            return this;
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
			// call image uploader crop
			this.ready();
            this.toggleEditForm();
            this.setImgUploaderCrop();
		},

        /**
		* fires libraries js
		*/
		ready: function () {
			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				$(document).foundation('dropdown', 'reflow');
				$(document).foundation('abide', 'reflow');
			}

			if( typeof(window.initComponent.select2Trigger) == 'function' && _.has($.fn, 'select2') ) {
				window.initComponent.select2Trigger();
            }

			if( typeof(window.initComponent.configSlick) == 'function' && _.has($.fn, 'slick') ) {
				window.initComponent.configSlick();
            }

			if( typeof(window.initComponent.initLightBox) == 'function' && _.has($.fn, 'imageLightbox') ) {
				window.initComponent.initLightBox();
            }

            if( typeof(window.initComponent.datepickerTrigger) == 'function' ) {
                window.initComponent.datepickerTrigger();
            }

            if( typeof(window.initComponent.configInputMask) == 'function' && _.has($.fn, 'inputmask') ) {
                window.initComponent.configInputMask();
            }

			if( typeof window.initComponent.initConfigForm == 'function' ) {
				window.initComponent.initConfigForm();
            }

			if( typeof window.initComponent.configEllipsis == 'function' && _.has($.fn, 'dotdotdot') ) {
                window.initComponent.configEllipsis();
            }
		},

        /**
		* reference to views
		*/
		referenceViews: function () {
            var _this = this;

			// instance of edit view
			this.eventEdit = new app.EventEdit({
				model: this.model,
				parameters: {
				   //
				}
			});

            // button participants view all
            this.eventParticipantsCallView = new app.EventParticipantsCallView({
                model: this.model
            });
		},

        /**
		* render info toggleEditForm
		*/
		toggleEditForm: function (model, value, opts) {
			var validate = this.model.get('owner') ? true : false;

			this.$('#content-detail-event').toggleClass('editable', validate);
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
                'direct': false
            });
        },

        /*
        * Render title
        */
        renderEventTitle: function (model, value, opts) {
            this.$('#event-title-main').html( this.templateTitle( this.model.toJSON() ) );
        },

        /*
        * Render city
        */
        renderEventCity: function (model, value, opts) {
            this.$('#event-city-main').html( this.templateCity( this.model.toJSON() ) );
        },

        /*
        * Render date
        */
        renderEventDate: function (model, value, opts) {
            this.$('#event-date-main').html( this.templateDate( this.model.toJSON() ) );
        },

        /**
		* render info description
		*/
		renderInfoDescription: function (model, value, opts) {
			this.$('#event-infodescription-container').removeClass('editing').html( this.templateDescription(this.model.toJSON()) );
		},

        /**
        *   render button participate event
        */
        renderButtonParticipate: function () {
            if ( this.eventUser instanceof Backbone.View ){
                this.eventUser.stopListening();
                this.eventUser.undelegateEvents();
            }

            // Instance view button register
			this.eventUser = new app.UserEventView({
                el: this.$wrapEventUser,
				model: this.modelEventUser,
                collection: this.usersEventList,
				parameters: {
				    data: {
                        view: this.model.get('view'),
                        wrapper: this.$wrapEventUserList,
                        codigo_evento: this.model.get('codigo_evento')
                    }
				}
			});

            if(!_.isUndefined(this.model.get('register')) && this.model.get('register')){
                this.modelEventUser.set({codigo_usuario_evento: this.model.get('codigo_usuario_evento')});

                if(this.model.hasChanged('view') && this.model.get('view')){
                    this.modelEventUser.fetch();
                }else{
                    this.eventUser.render();
                }
            }else{
                this.eventUser.render();
            }
        },

        // render users event
        renderUsersEvent: function () {
            var view = new app.UsersEventListView({
                el: this.$wrapEventUserList,
                collection: this.usersEventList,
                parameters: {
                    data: {
                        btnViewParts: this.$btnViewParts
                    }
                }
            });

            this.usersEventList.fetch({data: {codigo_evento: this.model.get('codigo_evento'), limit: 5}, reset: true});
        },

        /**
        * change project image main
        */
        onChangeImage: function (e) {

            if( e !== undefined ){
                e.preventDefault();
            }

            this.$modalImageCrop.on('opened', this.openModalImg);
            $(document).on('closed.fndtn.reveal', this.$modalImageCrop, this.closeModalImg);

            this.$modalImageCrop.foundation('reveal', 'open');
        },

        /**
        * handler event with avatar modal is opened
        */
        openModalImg: function (e) {

            var _this = this;

            if( this.$el.data('imageUploaderCrop') !== undefined ) {
                this.$el.imageUploaderCrop('changeImage', this.model.get('imagen_evento'));
            }
        },

        /**
        * handler event on crop modal is closed
        */
        closeModalImg: function (e) {

            if(e.namespace != 'fndtn.reveal'){
                return;
            }

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

        // ===============================================================
        //              start of image uploader crop
        // ===============================================================

        /**
        * set image uploader crop
        */
        setImgUploaderCrop: function () {

            var _this = this;

            this.$el.imageUploaderCrop({
				formCrop: $('#form-event-crop'),
				imgCrop: $('#image-event-tocrop'),
				previewImg: $('#event-preview-tocrop'),
				uploaderImg: $('#uploader-image-event'),
				templateImgUploader: 'qq-img-uploader-template',
				configImg: {
                    maxWidthImg : 780 * 4,
					maxHeightImg : 520 * 4,
					minWidthImg : 780,
					minHeightImg : 520
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
				extraDropzones: [$('#image-crop-event')],
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
								_this.model.save({action: 'edit-event', imagen_evento: resp.file_path}, {patch: true});

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
                messages: window._tp.messages,
			});
        }
    });

})(jQuery, this, this.document);
