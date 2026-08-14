/**
* Class ProductGalleryImage extends of Backbone View
* @author TuProyecto || Desarrollador : @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ProductGalleryImage = Backbone.View.extend({

		tagName: 'li',
		template: _.template( ($('#product-attachment-item-tpl').html() || '') ),
		events: {
			'click .change-image-gallery': 'onChangeImage'
		},
		parameters: {
			cod_involved: null
		},

		/**
		* Constructor Method
		*/
		initialize: function(opts){
			_.bindAll(this, 'beforeRender', 'render', 'afterRender', 'openModalImg', 'closeModalImg');

			if( opts !== undefined && _.isObject(opts.parameters) )
				this.parameters = $.extend({}, this.parameters, opts.parameters);

			//Init Attributes
			this.$modalImageCrop = $('#modal-image-product');

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

			// Events Listener
			this.listenTo( this.model, "change", this.render );
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );

			// Events customize
		},

		/*
		* Render View Element
		*/
		render: function(){

			var attributes = this.model.toJSON();
			this.$el.html( this.template(attributes) );

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

			this.ready();
		},

		/**
		* fires libraries js
		*/
		ready: function () {

			var _this = this;

			// call image uploader crop
			this.renderUploaderGalleryImg();
		},

		// ===============================================================
		//              start of image uploader crop
		// ===============================================================

		/**
		* set image uploader crop
		*/
		renderUploaderGalleryImg: function () {

			var _this = this;

			this.$el.imageUploaderCrop({
				formCrop: $('#form-product-crop'),
				imgCrop: $('#image-product-tocrop'),
				previewImg: $('#product-preview-tocrop'),
				uploaderImg: $('#uploader-image-product'),
				templateImgUploader: 'qq-img-uploader-template',
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
				extraDropzones: [_this.$('.image-area-drop'), $('#image-crop-product')],
				// Events handlers
				callbacks: {
					onLoadImg: function ($uploaderImg, id, name) {

						var $areaDrop = $uploaderImg.fineUploader('getDropTarget', id);

						if( $areaDrop !== undefined && $areaDrop.length ){
							if( $areaDrop.hasClass('image-area-drop') ){
								_this.$('.change-image-gallery:eq(0)').trigger('click');

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
								_this.model.set('direccion_adjunto', resp.file_path);

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

			if( e !== undefined ){
				e.preventDefault();
			}

			this.$modalImageCrop.on('opened.fndtn.reveal', this.openModalImg);
			$(document).on('closed.fndtn.reveal', this.$modalImageCrop, this.closeModalImg);

			this.$modalImageCrop.foundation('reveal', 'open');
		},

		/**
		* event handler with avatar modal is opened
		*/
		openModalImg: function (e) {

			var _this = this;

			if( this.$el.data('imageUploaderCrop') !== undefined ) {
				this.$el.imageUploaderCrop('changeImage', this.model.get('direccion_adjunto'));
			}
		},

		/**
		* event handler on crop modal is closed
		*/
		closeModalImg: function (e) {

			if(e.namespace != 'fndtn.reveal') {
				return;
			}

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
		}
	});

})(jQuery, this, this.document);
