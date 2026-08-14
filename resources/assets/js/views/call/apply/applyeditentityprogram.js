/**
* Class ApplyEditEntityProgramView extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ApplyEditEntityProgramView = Backbone.View.extend({
		el: '#content-data-entity-program',
		template: _.template( ($('#entity-edit-program-tpl').html() || '') ),
		templateFormCompany: _.template( ($('#form-create-company-tpl').html() || '') ),
		templateFormEntrepreneurship: _.template( ($('#form-create-entrepreneurship-tpl').html() || '') ),
		templateFormGroup: _.template( ($('#form-create-group-tpl').html() || '') ),
        templateIdentifications: _.template( ($('#identification-type-tpl').html() || '') ),
		events: {
			'submit #form-edit-entity-program': 'onEditEntity',
			'click #change-img-entity-program': 'onChangeImage',
			'click .change-video-entity-program': 'onChangeVideo',
            'change #codigo_tipo_identificacion': 'onChangeTypeID'
		},
		parameters: {
			url_convocatoria: '',
			step: '',
			dataFilter: {}
		},

		/**
		* Constructor Method
		*/
		initialize: function (opts) {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender', 'openModalImg', 'closeModalImg');

			// extends parameters
			if( opts.parameters !== undefined && _.isObject(opts.parameters) )
				this.parameters = $.extend({}, this.parameters, opts.parameters);

			//Init Attributes
			this.$modalImageCrop = $('#modal-image-project');
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

			// Events Listener
			this.listenTo( this.model, 'change', this.render );
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );

			// Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );
			this.on( 'getdata', this.getFirstData );
		},

		/*
		* Render View Element
		*/
		render: function () {

			var attributes = this.model.toJSON();
			attributes['url_convocatoria'] = this.parameters.url_convocatoria;
			attributes['step'] = this.parameters.step;
			
			this.$el.html( this.template(attributes) );

			// Initialize attributes
			this.$wrapEditEntity = this.$('#wrap-edit-entity-program');
			this.$formEdit = this.$('#form-edit-entity-program');

			// overwrite model id attribute
            if( this.model.changed.codigo_entidad !== undefined ) {

                // Overwrite id attribute of the model
                this.model.idAttribute = 'codigo_entidad';
                this.model.set( {'codigo_entidad': this.model.get('codigo_entidad')}, {'silent':true} );
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
				$(document).foundation('abide', 'reflow');
				$(document).foundation('tooltip', 'reflow');
				$(document).foundation('dropdown', 'reflow');
			}

			// reload plugins
			if( typeof window.initComponent.select2Trigger == 'function' && _.has($.fn, 'select2') )
				window.initComponent.select2Trigger();

            if( typeof window.initComponent.configInputMask == 'function' && _.has($.fn, 'inputmask') )
				window.initComponent.configInputMask();

			if( typeof window.initComponent.datepickerTrigger == 'function' && _.has($.fn, 'datetimepicker') )
				window.initComponent.datepickerTrigger();

			if( typeof window.initComponent.initConfigForm == 'function' )
				window.initComponent.initConfigForm();
		},

		/**
		* get reset data
		* @param dataFilter Object
		* @param replace Boolean
		*/
		getFirstData: function  (dataFilter, replace) {

			dataFilter || (dataFilter = {});
			replace || (replace = false);

			if(replace) {
				this.parameters.dataFilter = dataFilter;
			}else{
				_.extend( this.parameters.dataFilter, dataFilter );
			}

			this.model.fetch( {data:_.clone(this.parameters.dataFilter)} );
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
			// response success or error
			var type = resp.success ? 'success' : 'alert',
				text = resp.success ? (resp.message !== undefined ? resp.message : '') : resp.errors;

			if( _.isObject( resp.errors ) ) {

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

			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': true,
				'callback': (function (conf, re, _this) {
					return function () {

						if( re.success !== undefined ) {
							if( re.success ){
								// $formReset[0].reset();
								// $formReset.find('.chosen-select')
								// 		  .trigger("chosen:updated");

							}else{
								window.Misc.showAlertBox( conf );
							}
						}
						if( _this.model.changed.codigo_entidad !== undefined ) {
							_this.renderEditEntity();
						}
					}
				})(this.configAlert, resp, this)
			});
		},

		/**
		* render entity edit form
		*/
		renderEditEntity: function () {
			switch( parseInt(this.model.get('codigo_clase_emprendimiento')) ) {
				case window._tp.getClassEntrepreneurship['company']:
						this.$wrapEditEntity.html( this.templateFormCompany(this.model.toJSON()) );
                        // if( !_.isUndefined(this.model.get('codigo_tipo_identificacion')) && !_.isNull(this.model.get('codigo_tipo_identificacion')) && this.model.get('codigo_tipo_identificacion') != 0 ){
                        //     this.validateInputIdentity( this.model.get('codigo_tipo_identificacion') );
                        // }else{
                            this.validateInputIdentity();
                        // }
					break;

				case window._tp.getClassEntrepreneurship['entrepreneurship']:
						this.$wrapEditEntity.html( this.templateFormEntrepreneurship(this.model.toJSON()) );
					break;

				case window._tp.getClassEntrepreneurship['group']:
						this.$wrapEditEntity.html( this.templateFormGroup(this.model.toJSON()) );
					break;

				default:
					this.$wrapEditEntity.html('');
					// $('#form-purchase-payment').find(':submit').removeClass('disabled');
				break;
			}

			this.ready();
		},

		/**
		* on edit entity
		*/
		onEditEntity: function (e) {
			e.preventDefault();

			var _this = this;
			var data = window.Misc.formToJson(e.target);

			this.model.save( data, {patch: true, wait:true, success: function (model, resp, opts) {

				if( resp.success !== undefined ) {

					if( resp.success && _this.parameters.applyProgramView instanceof Backbone.View ) {
						_this.parameters.applyProgramView.getForm(false);
					}
				}

				return;

			}} );
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
				formCrop: $('#form-project-upload-crop'),
				imgCrop: $('#img-project-tocrop'),
				previewImg: $('#project-preview-tocrop'),
				uploaderImg: $('#uploader-image-project'),
				templateImgUploader: 'qq-img-uploader-template',
				configImg: {
					maxWidthImg : 770 * 4,
					maxHeightImg : 460 * 4,
					minWidthImg : 770,
					minHeightImg : 460
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
				extraDropzones: [/*this.$('#project-main-image'),*/ $('#image-crop-project')],
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

								_this.$('.image-entity-program').attr('src', resp.file_path);
								_this.$('#imagen_usuario').val(resp.file_path);

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
		* on change video
		*/
		onChangeVideo: function (e) {
			e.preventDefault();

			if( this.projectEditVideo instanceof Backbone.View ){
				this.projectEditVideo.stopListening();
				this.projectEditVideo.undelegateEvents();
			}

			this.projectEditVideo = new app.ProjectEditVideo({
				model: this.model,
				parameters: {
					dropdown: $('#drop-edit-form-lg'),
					canSave: false
				}
			});

			$('#drop-edit-form-lg').html( this.projectEditVideo.render().el );
		},

        /**
        * Change type ID
        */
        onChangeTypeID: function (e) {
            //e.preventDefault();
            var typeIdentity = $(e.currentTarget).val();
            this.validateInputIdentity( typeIdentity );
        },

        validateInputIdentity: function (data) {
            
            var attributes = this.model.toJSON(),
                classInput = '',
                limit = '';

            if( data == window._tp.getTypeID['cc'] || data == window._tp.getTypeID['nit'] || data == window._tp.getTypeID['ti'] ){
                attributes.classInput = 'indetification-mask';
                if( data == window._tp.getTypeID['nit'] ){
                    attributes.limit = '9';
                }else{
                    attributes.limit = '10';
                }
            }

            this.$('#identification-type').html( this.templateIdentifications( attributes ) );
            this.$('#identificacion_usuario').attr( 'disabled', true ).css('border-bottom', "1px solid rgba(0, 0, 0, 0.3)");
            this.$('#codigo_tipo_identificacion').attr( 'disabled', true ).css('border-bottom', "1px solid rgba(0, 0, 0, 0.3)");
            this.ready();
        }
	});

})(jQuery, this, this.document);
