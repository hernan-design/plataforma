/**
* Class MarketPlaceCreatePromotionView extends of Backbone View
* @author TuProyecto || Desarrollador : @dortegon
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.MarketPlaceCreatePromotionView = Backbone.View.extend({

		el: '#create-promotion-marketplace',
		template: _.template( ($('#marketplace-create-promotion-tpl').html() || '') ),
		templateMainImg: _.template( ($('#main-image-promotion-create-tpl').html() || '') ),
		events:{
            'change #tipo_promocion': 'onProduct',
			'submit #form-create-promotion': 'onStore',
			'click #change-image-promotion': 'onChangeImage'
		},
        parameters: {
            update: ''
        },

		/**
		* Constructor Method
		*/
		initialize : function() {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender', 'openModalImg', 'closeModalImg', 'closeModal');

			this.$modalImageCrop = $('#modal-image-promotion');
            this.$modalCreateEntity = $('#modal-base-material');

			var _this = this;
			this.$modalImageCrop.off('click.closeCropModal').on('click.closeCropModal', '.close-reveal-modal', function (e) {
				e.preventDefault();
				_this.closeModal();
			});

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
            this.listenTo( this.model, 'change', this.render );
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'change:imagen_promocion', this.renderMainImage );
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );
		},

		/*
		* Render View Element
		*/
		render: function(){
            var attributes = {};

            // if(_.isUndefined(this.model)){
            //     this.model = new app.PromotionModel();
            // }

            // if(this.parameters.update){
                attributes = this.model.toJSON();
            // }


			this.$el.html( this.template(attributes) );

			// Initialize attributes
            this.$formCreate = $('#form-create-promotion');

			this.renderMainImage();
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

            this.$activeProduct = this.$('.choice-product');
            this.$selectProduct = this.$('#codigo_producto');
            this.$discountRateProduct = this.$('#porcentaje_descuento_promocion');
            this.$inputPercentage = this.$('.input-percentage');

            if( !_.isNull(this.model.get('tipo_promocion')) ){
                this.onValProduct(this.model.get('tipo_promocion'));
            }else{
                this.$activeProduct.toggleClass('hide', true);
                this.$discountRateProduct.toggleClass('hide', true);
                this.$inputPercentage.toggleClass('hide', true);

            }

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

            if( typeof window.initComponent.datepickerTrigger == 'function' && _.has($.fn, 'datetimepicker') ){
                window.initComponent.datepickerTrigger();
            }
		},

		/**
		* @param Object promotionModel model instance
		* @param Object options object hash
		*/
		fetchOne: function (promotionModel) {

			if (this.model.changed.codigo_promocion === undefined){
                return;
            }

			app.AppRouter.navigate( Route.route( 'marketplace.ventas.promocion.edit', { promocion: promotionModel.get('codigo_promocion') }), {trigger: true});
		},

		/**
		* Event Create Forum Post
		*/
		onStore: function (e) {
			e.preventDefault();

			var data = window.Misc.formToJson( e.target );

            if(_.isEmpty(data.imagen_promocion)){
    			var config = {
    				'text': 'Se debe cargar una imagen',
    				'type': 'alert'
    			};
    			_.extend( this.configAlert, config );

                window.Misc.showAlertBox( this.configAlert );
                return;
            }

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
			var text = resp.success ? resp.message : resp.errors,
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
                        if( re.success !== undefined ) {
                            window.Misc.showAlertBox( conf );
    						if( re.success ){
                                $formReset[0].reset()
                                $formReset.find('.chosen-select')
                                .trigger("chosen:updated");

                                app.AppRouter.navigate( Route.route( 'marketplace.ventas.promocion.index'), {trigger: true} );
    						}
                        }
					}
				})(this.configAlert, resp, this.$formCreate)
			});
		},

		/**
		* render main image
		*/
		renderMainImage: function (model, value, opts) {
			this.$('#promotion-main-image').html( this.templateMainImg(this.model.toJSON()) );
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
				formCrop: $('#form-promotion-crop'),
				imgCrop: $('#image-promotion-tocrop'),
				previewImg: $('#promotion-preview-tocrop'),
				uploaderImg: $('#uploader-image-promotion'),
				templateImgUploader: 'qq-img-promotion-uploader-template',
				configImg: {
					maxWidthImg : 1180 * 2,
					maxHeightImg : 320 * 2,
					minWidthImg : 1180,
					minHeightImg : 320
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
				extraDropzones: [$('#image-crop-promotion')],
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
								_this.model.set('imagen_promocion', resp.file_path);

								_this.closeModal();
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

			if( e !== undefined ){
                e.preventDefault();
            }

			this.$modalImageCrop.on('opened.fndtn.reveal', this.openModalImg);
			$(document).on('closed.fndtn.reveal', this.$modalImageCrop, this.closeModalImg);

			this.$modalImageCrop.foundation('reveal', 'open');
		},

		/**
		* handler event with avatar modal is opened
		*/
		openModalImg: function (e) {
			if( this.$el.data('imageUploaderCrop') !== undefined && this.model.get('imagen_promocion') ){
                this.$el.imageUploaderCrop('changeImage', this.model.get('imagen_promocion'));
            }
		},

		/**
		* Programmatic safe close for crop modal
		*/
		closeModal: function () {
			if (window.Foundation && window.Foundation.libs && window.Foundation.libs.reveal) {
				window.Foundation.libs.reveal.locked = false;
			}
			try {
				this.$modalImageCrop.foundation('reveal', 'close');
			} catch(e) {}

			var _this = this;
			setTimeout(function() {
				if (_this.$modalImageCrop.is(':visible') || $('.reveal-modal-bg').is(':visible')) {
					_this.$modalImageCrop.removeClass('open').hide().css({ visibility: 'hidden', opacity: 0 });
					$('.reveal-modal-bg').remove();
					$('body').removeClass('modal-open').css('overflow', '');
					_this.closeModalImg({ namespace: 'fndtn.reveal' });
				}
			}, 150);
		},

		/**
		* handler event on crop modal is closed
		*/
		closeModalImg: function (e) {

			if (e && e.namespace && e.namespace != 'fndtn.reveal') return;

			try {
				if (this.$el.data('imageUploaderCrop') !== undefined) {
					var $imgCrop = this.$el.imageUploaderCrop('getImgCrop'),
						$imgPreview = this.$el.imageUploaderCrop('getPreviewImg'),
						jcrop_img = null;

					if ($imgCrop && $imgCrop.length && $imgCrop.data('Jcrop') !== undefined) {
						$imgCrop.attr('src', '');
						$imgPreview.attr('src', '');
						jcrop_img = $imgCrop.data('Jcrop');
						jcrop_img.destroy();
					}
				}
			} catch (err) {
				console.warn('Error closing modal crop image:', err);
			}

			// detach events
			this.$modalImageCrop.off('opened.fndtn.reveal');
			$(document).off('closed.fndtn.reveal');
		},

        onProduct: function (e) {
            e.preventDefault();
            var selector = $(e.currentTarget).val();

            this.onValProduct(selector);
        },

        onValProduct: function (selector) {
            if(selector == window._tp.getTypePromo['promotion']){
                // active
                this.$activeProduct.toggleClass('hide', false);
                this.$discountRateProduct.toggleClass('hide', false);
                this.$inputPercentage.toggleClass('hide', false);

                // is required
                this.$selectProduct.attr('required', 'required');
                this.$discountRateProduct.attr('required', 'required');
            }else{
                // clear data
                this.$discountRateProduct.val('0');
                this.$selectProduct.val(null).trigger('change');

                // remove attr required
                this.$selectProduct.removeAttr('required');
                this.$discountRateProduct.removeAttr('required');

                // inactive
                this.$activeProduct.toggleClass('hide', true);
                this.$discountRateProduct.toggleClass('hide', true);
                this.$inputPercentage.toggleClass('hide', true);

                // reload select materialize
                if( this.$selectProduct.hasClass('initialized') ) {
                    this.$selectProduct.material_select();
                }
            }
        }
   });

})(jQuery, this, this.document);
