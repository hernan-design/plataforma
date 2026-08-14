/**
* Class MarketPlaceCreateProductView extends of Backbone View
* @author TuProyecto || Desarrolladores : @xindykatalina, @krobing, @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MarketPlaceCreateProductView = Backbone.View.extend({

		el: '#create-product-marketplace',
		template: _.template( ($('#marketplace-create-product-tpl').html() || '') ),
		templateMainImg: _.template( ($('#main-image-product-create-tpl').html() || '') ),
		events:{
            'change #type_owner': 'onChangeType',
			'submit #form-create-product': 'onStore',
            'change #seg_codigo_usuario': 'onCreateEntity',
			'click #change-image-product': 'onChangeImage',
            'change #codigo_clase_producto': 'onModality',
            'change #producto_sin_precio': 'onChangeFreeProduct'
		},

		/**
		* Constructor Method
		*/
		initialize : function() {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender', 'openModalImg', 'closeModalImg');

			//Init Attributes
            this.project = new app.ProjectModel();
            this.programModel = new app.CallModel();
			this.model = new app.MarketPlaceModel();
			this.gallery = new app.AttachmentList();

			this.$modalImageCrop = $('#modal-image-product');
            this.$modalCreateEntity = $('#modal-base-material');

			this.configAlert = {
				'wrapper': '#main-wrap',
				'closeTime': 6000,
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

			//Events Listener
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'change:codigo_producto', this.fetchOne );
            this.listenTo( this.model, 'change:imagen_producto', this.renderMainImage );
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );
		},

		/*
		* Render View Element
		*/
		render: function(){

            var _this = this,
                attributes = {};

			this.$el.html( this.template(attributes) );

			// Initialize attributes
            this.$formCreate = $('#form-create-product');
            this.$selectorEntity = this.$('#selector-entity');
            this.$ownerEntity = this.$('#seg_codigo_usuario');
			this.$galleryEdit = this.$('#product-gallery-edit');
            this.$modality = this.$('#modalidad_prestacion_servicio');

			if( this.model.changed.codigo_producto !== undefined ){
				// instance gallery view
			}

			this.galleryImages = new app.ProductGallery({
				el: this.$galleryEdit,
				collection: this.gallery,
				parameters: {
					'codigo_producto': this.model.get('codigo_producto'),
					thumbs: 9,
					dataFilter: {
						'product': this.model.get('codigo_producto')
					}
				}
			});

			this.gallery.reset();

            // React component simple-editor
            ReactDOM.render(React.createElement(SimpleEditor, {
                content: _this.model,
                // formCreate: _this.$formCreate,
                value: _this.model.get('descripcion_producto'),
                name: "descripcion_producto",
                options: {
                    placeholder: 'Descripción',
                    toolbar: [
                        ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                        ['para', ['ul', 'ol', 'paragraph', 'height']],
                        ['insert', ['link']]
                    ]
                }
            }, null), document.getElementById('form-product-editor'));

			this.renderMainImage();
            this.referenceViews();
		},

		/**
		* Fires before of run render function
		*/
		beforeRender: function() {
			//
		},

		/**
		* Fires before of run render function
		*/
		afterRender: function() {
			// call image uploader crop
			this.setImgUploaderCrop();
			this.ready();

            this.$unitsProduct = this.$('.ui-spinner');
            this.$btnCallModal = this.$('#btn-modal-base-create-entity');
            this.$choiceEntitiesProduct = this.$('.choice-entities-product');
            this.$choiceModalityProduct = this.$('.choice-modality-product');

            this.$btnCallModal.addClass('disabled');
            this.$unitsProduct.toggleClass('disabled', true);
            this.$choiceEntitiesProduct.toggleClass('disabled', true);
            this.$choiceModalityProduct.toggleClass('disabled', true);
		},

		/**
		* fires libraries js
		*/
		ready: function () {

			var _this = this;

			// trigger libraries
			if( _.has($.fn, 'foundation') ){
				$(document).foundation('abide', 'reflow');
			}

			// reload plugins
			if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' ){
                window.initComponent.select2Trigger();
            }

			if( typeof window.initComponent.initConfigForm == 'function' ){
                window.initComponent.initConfigForm();
            }

			if( typeof window.initComponent.spinnerTrigger == 'function' && _.has($.fn, 'sspinner') ){
                window.initComponent.spinnerTrigger();
            }

			if( typeof window.initComponent.initLightBox == 'function' && _.has($.fn, 'imageLightbox') ){
                window.initComponent.initLightBox();
            }

			if( typeof window.initComponent.configInputMask == 'function' && _.has($.fn, 'inputmask') ){
                window.initComponent.configInputMask();
            }
		},

        /**
        *  Reference to view
        */
        referenceViews: function () {

            // entity apply program view
			this.applyEntityView = new app.ApplyEntityProgramView({
				el: this.$el,
				model: this.entityModel,
				parameters: _.extend({
                    step: '',
                    url_convocatoria: '',
                    applyProgramView: this,
                    programModel: this.programModel,
                    select: this.$ownerEntity
                })
			});
        },

		/**
		* fetch category of the foro theme and reload on collection view
		* @param Object forumModel model instance
		* @param Object options object hash
		*/
		fetchOne: function (MarketPlaceModel) {

			if (this.model.changed.codigo_producto === undefined){
                return;
            }

			app.AppRouter.navigate( Route.route( 'marketplace.show', { marketplace: this.model.get('url_producto') }), {trigger: true});
		},

		/**
		* Event Create Forum Post
		*/
		onStore: function (e) {
			e.preventDefault();

			var data = window.Misc.formToJson( e.target );
			data['images_gallery'] = this.gallery.toJSON();

			data.precio_producto = Globalize.numberParser()(data.precio_producto);
			this.model.save( data, {patch:true, wait:true} );
		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function (model, xhr, opts) {

			window.Misc.setSpinner( this.$el );
		},

		/**
		* response of the server
		*/
		responseServer: function ( model, resp, opts ) {

			// response success or error
			var text = resp.success ? 'El producto se creó con éxito.' : resp.errors,
				type = resp.success ? 'success' : 'alert';

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

			//complete proccess
			window.Misc.removeSpinner({
				'wrap': this.$el,
				'direct': false,
				'callback': (function (conf, re, $formReset) {
					return function () {

						window.Misc.showAlertBox( conf );
						if( re.success ){

							$formReset[0].reset()
							$formReset.find('.chosen-select')
									  .trigger("chosen:updated");
						}
					}
				})(this.configAlert, resp, this.$formCreate)
			});
		},

		/**
		* render main image
		*/
		renderMainImage: function (model, value, opts) {
			this.$('#product-main-image').html( this.templateMainImg(this.model.toJSON()) );
			this.ready();
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
				formCrop: $('#form-product-crop'),
				imgCrop: $('#image-product-tocrop'),
				previewImg: $('#product-preview-tocrop'),
				uploaderImg: $('#uploader-image-product'),
				templateImgUploader: 'qq-img-product-uploader-template',
				configImg: {
					maxWidthImg : 646 * 4,
					maxHeightImg : 374 * 4,
					minWidthImg : 646,
					minHeightImg : 374
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
				extraDropzones: [/*this.$('#project-main-image'),*/ $('#image-crop-product')],
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
								_this.model.set('imagen_producto', resp.file_path);

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

			this.$modalImageCrop.on('opened.fndtn.reveal', this.openModalImg);
			$(document).on('closed.fndtn.reveal', this.$modalImageCrop, this.closeModalImg);

			this.$modalImageCrop.foundation('reveal', 'open');
		},

		/**
		* handler event with avatar modal is opened
		*/
		openModalImg: function (e) {

			var _this = this;

			if( this.$el.data('imageUploaderCrop') !== undefined ){
                this.$el.imageUploaderCrop('changeImage', this.model.get('imagen_producto'));
            }
		},

		/**
		* handler event on crop modal is closed
		*/
		closeModalImg: function (e) {

			if(e.namespace != 'fndtn.reveal') return;

			var $imgCrop = this.$el.imageUploaderCrop('getImgCrop'),
				$imgPreview = this.$el.imageUploaderCrop('getPreviewImg'),
				jcrop_img = null;

			// check out if already was assigned the jcrop library
			if( $imgCrop.data('Jcrop') !== undefined ){
				$imgCrop.attr('src', '');
				$imgPreview.attr('src', '');
				jcrop_img = $imgCrop.data('Jcrop');
				jcrop_img.destroy();
			}

			// detach events
			this.$modalImageCrop.off('opened.fndtn.reveal');
			$(document).off('closed.fndtn.reveal', this.$modalImageCrop);
		},

        /**
        *  onChangeFreeProduct
        */
        onChangeFreeProduct: function (e) {
            var checked = this.$(e.currentTarget).prop('checked');
            if(checked){
                    this.$('#precio_producto').prop('readonly', true);
                    this.$('#precio_producto').prop('required', false);
            }else{
                this.$('#precio_producto').prop('readonly', false);
                 this.$('#precio_producto').prop('required',true);
            }
        },

        /**
        *  onChangeType
        */
        onChangeType: function (e) {
            e.preventDefault();
            var selector = $(e.currentTarget).val();

            if(selector == 1){
				this.$ownerEntity.val(0);
				this.$ownerEntity.trigger('change');

    			// reload select materialize
    			if( this.$ownerEntity.hasClass('initialized') ) {
                    this.$ownerEntity.material_select();
                }

                this.$('.choice-entities-product').toggleClass('disabled', true);
                this.$ownerEntity.removeAttr('required');
                this.$btnCallModal.addClass('disabled');
            }

            if(selector == 2){
                this.$('.choice-entities-product').toggleClass('disabled', false);
                this.$ownerEntity.attr('required', 'required');
                this.$btnCallModal.removeClass('disabled');
            }
        },

        onModality: function (e) {
            e.preventDefault();
            var selector = $(e.currentTarget).val();

            if(selector == window._tp.classProduct['service']){
                this.$('.choice-modality-product').toggleClass('disabled', false);
                this.$modality.attr('required', 'required');

                this.$("input[name='cantidad_producto']").val('0');
                this.$('#cantidad_producto').val('0');
                this.$unitsProduct.toggleClass('disabled', true);
                this.$unitsProduct.removeAttr('required');
            }else{
                this.$modality.val(0);
				this.$modality.trigger('change');

                // reload select materialize
    			if( this.$modality.hasClass('initialized') ) {
                    this.$modality.material_select();
                }

                this.$unitsProduct.toggleClass('disabled', false);
                this.$unitsProduct.attr('required', 'required');

                this.$('.choice-modality-product').toggleClass('disabled', true);
                this.$modality.removeAttr('required');
            }
        }
   });

})(jQuery, this, this.document);
