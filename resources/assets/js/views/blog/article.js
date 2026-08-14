/**
* Class ArticleView extend of Backbone View
* @author TuProyecto || Desarrollador : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ArticleView = Backbone.View.extend({

		el: '#blog-content',
		template: _.template( ($('#article-detail-tpl').html() || '') ),
		templateMainImg: _.template( ($('#main-image-article-create-tpl').html() || '') ),
		templateTitle: _.template( ($('#info-article-tpl').html() || '') ),
		templateDescription: _.template( ($('#info-description-article-tpl').html() || '') ),
		events: {
			// 'submit #form-comment-article': 'onStore',
            'click #change-image-article': 'onChangeImage',
			'click .article-shared-list .show-user-likes': 'onShowUserLikes'
		},

		/**
		* Constructor Method
		*/
		initialize : function() {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'openModalImg', 'closeModalImg');
			//Init Attribute
			this.mostViewedArticlesList = new app.MostViewedArticlesList();
			this.likeList = new window.app.LikeList();
			this.$modalBase = $('#modal-base-material');
			this.discussionList = new app.DiscussionList();
			this.$modalImageCrop = $('#modal-image-article');
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
			this.listenTo( this.model, 'change', this.render );
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.model, 'change:state_article', this.toggleEditForm );
			this.listenTo( this.model, 'change:imagen_contenido', this.renderMainImage );
			this.listenTo( this.model, 'change:nombre_contenido', this.renderInfoTitle );
			this.listenTo( this.model, 'change:texto_contenido', this.renderInfoDescription );

            // Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );
		},

		/*
		* Render View Element
		*/
		render: function() {

			var attributes = this.model.toJSON();

			if( _.isObject(this.attributes) && this.attributes.category !== undefined ){
				attributes.category = this.attributes.category;
			}

			this.$el.html( this.template(attributes) );
			this.$wrapperDiscussion = this.$('#wrapper-posts-discussion');

			//Initialize Reference to elements
			this.$likeLink = this.$('.data-post-share.TPlikelink');
			this.$countLikes = this.$('.data-count-likes');
			this.$wrapperMostviewed = this.$('#content-mostviewed-list');
			this.$buttonsActions = this.$('#buttons-article-action');

			 // overwrite attribute id of the model
			if( this.model.changed.codigo_contenido ){
				this.model.idAttribute = 'codigo_contenido';
				this.model.set({'codigo_contenido':this.model.get('codigo_contenido')}, {'silent':true});

			   $(window).scrollTop(0);

               // redefine the URI
               this.model.returnToUrlRoot();
			}

			// instance of discussion view
			this.discussionListView = new app.DiscussionListView({
				el: this.$wrapperDiscussion,
				collection: this.discussionList,
				parameters: {
                    'formDiscussion': '#form-discussion-article',
                    dataFilter: {
                        'codigo_recurso_modulo': this.model.get('codigo_contenido'),
                        'codigo_modulo': window._tp.getModule('blog')
                    }
				}
			});

			//to render like link for post
			this.likeLinkView = new window.app.LikeView({
				el: this.$likeLink,
				collection: this.likeList,
				attributes: {
					'data-srcparams': this.model.get('srcparams')
				}
			});
			this.likeLinkView.$countLikes = this.$countLikes;

			// Trigger plugins
			if( _.has($.fn, 'foundation') ){
				this.$el.foundation('abide');
				$(document).foundation('tab', 'reflow');
				$(document).foundation('dropdown', 'reflow');
			}

			// Run functions plugins
			if( typeof window.initComponent.configSticky == 'function' )
				window.initComponent.configSticky();

			// intance of most view
			this.mostViewedArticleListView = new app.MostViewedArticleListView( {
				el: this.$wrapperMostviewed,
				collection: this.mostViewedArticlesList,
				parameters: {
					'mostView': 'MostViewInternalArticleView',
					'category': this.model.get('url_tipo_contenido')
				}
			} );
			this.mostViewedArticleListView.render();
			this.mostViewedArticleListView.trigger('getdata');

            // Instance of Buttons Actions Article
			this.buttonsArticle = new app.ArticleActionsView({
				el: this.$buttonsActions,
				model: this.model,
				parameters: {
					'type_action': ''
				}
			});

            // reference to views
            this.referenceViews();
            this.renderMainImage();
            this.renderInfoTitle();
            this.renderInfoDescription();

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
            this.toggleEditForm();
			this.setImgUploaderCrop();
			this.ready();
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

			if( typeof(window.initComponent.select2Trigger) == 'function' && _.has($.fn, 'select2') )
				window.initComponent.select2Trigger();

			if( typeof(window.initComponent.configSlick) == 'function' && _.has($.fn, 'slick') )
				window.initComponent.configSlick();

			if( typeof(window.initComponent.initLightBox) == 'function' && _.has($.fn, 'imageLightbox') )
				window.initComponent.initLightBox();

			if( typeof window.initComponent.initConfigForm == 'function' )
				window.initComponent.initConfigForm();

			if( typeof(window.initComponent.configInputMask) == 'function' && _.has($.fn, 'inputmask') )
				window.initComponent.configInputMask();
		},

        /**
		* reference to views
		*/
		referenceViews: function () {

			// instance of edit view
			this.articleEdit = new app.ArticleEdit({
				model: this.model,
				parameters: {
				   //
				}
			});

		},

        /**
		* render info toggleEditForm
		*/
		toggleEditForm: function (model, value, opts) {
			var validate = (this.model.get('owner') && ( this.model.get('state_article') == 'pending' || this.model.get('state_article') == 'inactive') ) ? true : false;

			this.$('#article-detail-content').toggleClass('editable', validate);
			this.$('#change-image-article').toggleClass('hidesoft', !validate);
		},

        /**
		* render main image
		*/
		renderMainImage: function (model, value, opts) {
			this.$('#article-main-image').html( this.templateMainImg(this.model.toJSON()) );
			this.ready();
		},

        /**
		* render info title
		*/
		renderInfoTitle: function (model, value, opts) {
			this.$('#article-main-title').html( this.templateTitle(this.model.toJSON()) );
			this.ready();
		},

        /**
		* render info description
		*/
		renderInfoDescription: function (model, value, opts) {
			this.$('#article-infodescription-container').removeClass('editing').html( this.templateDescription(this.model.toJSON()) );
			this.ready();
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
				parameters: {
					'data-srcparams': this.model.get('srcparams')
				}
			});
			this.$modalBase.find('.content-modal').html( this.viewUserLikes.render().el );
			this.$modalBase.find('.content-modal').append( this.viewUserLikes.$wrapViewMore );

			this.$modalBase.foundation('reveal','open');
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
				formCrop: $('#form-article-crop'),
				imgCrop: $('#image-article-tocrop'),
				previewImg: $('#article-preview-tocrop'),
				uploaderImg: $('#uploader-image-article'),
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
				extraDropzones: [/*this.$('#project-main-image'),*/ $('#image-crop-article')],
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
								_this.model.save({imagen_contenido: resp.file_path}, {patch: true});

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
		},

        /**
		* change product image main
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

			if( this.$el.data('imageUploaderCrop') !== undefined )
				this.$el.imageUploaderCrop('changeImage', this.model.get('imagen_contenido'));
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
			$(document).off('closed.fndtn.reveal');
		},
   });

})(jQuery, this, this.document);
