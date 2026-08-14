/**
* Class ProjectView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

	app.ProjectView = Backbone.View.extend({

		el: '#project-detail',
		template: _.template( ($('#project-detail-tpl').html() || '') ),
		templateTag: _.template( ($('#info-tag-project-tpl').html() || '') ),
		templateVideo: _.template( ($('#info-video-project-tpl').html() || '') ),
		templateMainImg: _.template( ($('#main-image-project-tpl').html() || '') ),
		templateTopDetail: _.template( ($('#info-basic-project-tpl').html() || '') ),
		templateSummary: _.template( ($('#info-summary-project-tpl').html() || '') ),
		templatePageWeb: _.template( ($('#info-pageweb-project-tpl').html() || '') ),
		templateNumeroWhatsapp: _.template( ($('#info-numerowhatsapp-project-tpl').html() || '') ),
		templateMailContact: _.template( ($('#info-mail-contact-project-tpl').html() || '') ),
		templateSocials: _.template( ($('#info-socials-project-tpl').html() || '') ),
		templateLocation: _.template( ($('#info-location-project-tpl').html() || '') ),
        templateStage: _.template( ($('#info-stage-project-tpl').html() || '') ),
		templateIndustry: _.template( ($('#info-industry-project-tpl').html() || '') ),
		templateDescription: _.template( ($('#info-description-project-tpl').html() || '') ),
		events: {
			'click .project-shared-list .show-user-likes': 'onShowUserLikes',
			'click .get-product-project': 'onGetProduct',
			'click .get-members-project': 'onGetMembers',
			'click .get-discussion-project': 'onGetDiscussion',
			'click .get-programs-project': 'onGetPrograms',
			'click .get-basic-project': 'onGetBasic',
			'click .get-documents-project': 'onGetDocument',
			'click .get-surveys-project': 'onGetSurvey',
			'click .get-business-model-project': 'onGetBusinessModel',
			'click #change-image-project': 'onChangeImage',
			'click .on-remove-project': 'onRemove',
			'change .editable .edit-gallery-images': 'onEditGallery',
			'click .onBack':'onBack',
			'click .user-vote': 'onUserVote'
		},
		parameters: {
			tab: 'basico'
		},
		isDefault: true,

		/**
		* Constructor Method
		*/
		initialize : function(opts) {
			_.bindAll(this, 'beforeRender', 'render', 'afterRender', 'openModalImg', 'closeModalImg');

			this.setElement( this.el );

			// extends parameters
			if( opts.parameters !== undefined && _.isObject(opts.parameters) )
				this.parameters = $.extend({}, this.parameters, opts.parameters);

			//Init Attribute
			this.$modalBase = $('#modal-base-tp');
			this.$modalUserVote = $('#modal-user-vote');
			this.$modalImageCrop = $('#modal-image-project');
			this.likeList = new app.LikeList();
			this.marketPlaceList = new app.MarketPlaceList();
			this.discussionList = new app.DiscussionList();
			this.callList = new app.CallList();
			this.callList.url = function () {
				return window.Misc.urlFull( Route.route('usuario.convocatorias.index') );
			};

			// Init google recaptcha
			// this.googleRecaptchaView = new app.GoogleRecaptchaView({ el: '.content-form-vote' });

			this.interestsList = new app.UserInterestsList();
			this.projectTeamList = new app.ProjectTeamList();
			this.projectSponsorList = new app.ProjectSponsorList();
			this.surveysList = new app.SurveysList();
			this.gallery = new app.ProjectAttachmentList();

            this.businessModel = new app.ProjectBusinessModel();

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
			this.listenTo( this.model, 'change:id_entidad', this.render );
			this.listenTo( this.model, 'change:imagen_usuario', this.renderMainImage );
			this.listenTo( this.model, 'change:nombre_usuario', this.renderInfoBasic );
			this.listenTo( this.model, 'change:codigo_ciudad', this.renderInfoLocation );
			this.listenTo( this.model, 'change:codigo_categoria_proyecto', this.renderInfoIndustry );
            this.listenTo( this.model, 'change:stage', this.renderInfoStage );
			this.listenTo( this.model, 'change:tags', this.renderInfoTag );
			this.listenTo( this.model, 'change:video_entidad', this.renderInfovideo );
			this.listenTo( this.model, 'change:descripcion_entidad', this.renderInfoDescription );
			this.listenTo( this.model, 'change:biografia_usuario', this.renderInfoSummary );
			this.listenTo( this.model, 'change:pagina_web_usuario', this.renderInfoPageWeb );
			this.listenTo( this.model, 'change:numero_whatsapp', this.renderInfoNumeroWhatsapp );
			this.listenTo( this.model, 'change:correo_contacto', this.renderMailContact );
			this.listenTo( this.model, 'change:facebook_usuario change:twitter_usuario change:linkedin_usuario change:tiktok_usuario', this.renderInfoSocials );
			this.listenTo( this.model, 'request', this.loadSpinner );
			this.listenTo( this.model, 'sync', this.responseServer );
			this.listenTo( this.gallery, 'change:direccion_adjunto', this.updateGallery );

			// Events Listener custome
			this.on( 'beforeRender', this.beforeRender );
			this.on( 'afterRender', this.afterRender );
		},

		/*
		* Render View Element
		*/
		render: function() {
			var attributes = this.model.toJSON();
			attributes.tab = this.parameters.tab;

			this.$el.html( this.template(attributes) );
			//console.log('Attributessss', attributes);

			// Initialize attributes
			this.$likeLink = this.$('.data-post-share.TPlikelink');
			this.$countLikes = this.$('.data-count-likes');
			this.$wrapperProduct = this.$('#project-product');
			this.$wrapperSurvey = this.$('#project-survey');
			this.$buttonsActions = this.$('#buttons-project-privacy-action');
			this.$wrapperDocuments = this.$('#wrap-documents');
			this.$galleryEdit = this.$('#project-gallery');

			// overwrite model id attribute
			if( this.model.changed.id_entidad !== undefined ) {

				// Overwrite id attribute of the model
				this.model.idAttribute = 'codigo_entidad';
				this.model.set( {'codigo_entidad': this.model.get('codigo_entidad')}, {'silent':true} );

				// reference to views
				this.renderMainImage();
				this.referenceViews();
				this.renderInfoBasic();
				this.renderInfovideo();
				this.renderInfoSocials();
				this.renderInfoLocation();
				this.renderInfoIndustry();
				this.renderInfoStage();
				this.renderInfoTag();
				this.renderInfoDescription();
				this.renderInfoSummary();
				this.renderInfoPageWeb();
				this.renderMailContact();
				this.renderInfoNumeroWhatsapp();
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
				this.$el.foundation('abide');
				$(document).foundation('dropdown', 'reflow');
				$(document).foundation('tab', 'reflow');
				$(document).foundation('tooltip', 'reflow');
			}

			// reload plugins
			if( typeof(window.initComponent.spinnerTrigger) == 'function' && _.has($.fn, 'spinner') )
				window.initComponent.spinnerTrigger();

			if( typeof(window.initComponent.configSticky) == 'function' && _.has($.fn, 'sticky') )
				window.initComponent.configSticky();

			if( typeof(window.initComponent.initTabs) == 'function' )
				window.initComponent.initTabs();

			if( typeof(window.initComponent.configSlick) == 'function' && _.has($.fn, 'slick') )
				window.initComponent.configSlick();

			if( typeof(window.initComponent.initLightBox) == 'function' && _.has($.fn, 'imageLightbox') )
				window.initComponent.initLightBox();

			// summary project for view more
			window.Misc.showMore({'container': this.$('.text-summary-project'), 'maxlen': 350});

			// summary project for view more
			window.Misc.showMore({'container': this.$('.text-pageweb-project'), 'maxlen': 350});

			window.Misc.showMore({'container': this.$('.text-numerowhatsapp-project'), 'maxlen': 350});
		},

		/**
		* reference to views
		*/
		referenceViews: function () {

			// Instance edit project view
			this.editProject = new app.EditProject({
				el: this.$el,
				model: this.model,
				parameters: {
					'interests': this.interestsList,
					'sponsors': this.projectSponsorList,
					'members': this.projectTeamList,
					'user': this.model.get('codigo_usuario'),
					'entity': this.model.get('codigo_entidad')
				}
			});

			if( this.editProject )
				this.editProject.render();

			// Instance of Buttons Actions Project
			this.buttonsPrivacyProject = new app.ProjectPrivacyActionsView({
				el: this.$buttonsActions,
				model: this.model,
				parameters: {
					'type_action': ''
				}
			});

			// Instance of Documents of Project
			this.projectEditDocuments = new app.ProjectEditDocuments({
				el: this.$wrapperDocuments,
				model: this.model,
				parameters: {
					//
				}
			});

			// Products
			this.projectProductListView = new app.ProjectProductListView({
				el: this.$wrapperProduct,
				collection: this.marketPlaceList,
				parameters: {
					dataFilter: {
						type: 'entity',
						'srcparams-user': this.model.get('codigo_usuario')
					}
			   }
			});

			// Discussions
			this.userDiscussionListView = new app.DiscussionListView({
				collection: this.discussionList,
				parameters: {
                    'formDiscussion': '#form-discussion-project',
                    dataFilter: {
                        'codigo_recurso_modulo': this.model.get('codigo_usuario'),
                        'codigo_modulo': window._tp.getModule('users')
                    }
				}
			});

			// Interests
			this.interestsList.fetch({
				data: {codigo_usuario: this.model.get('codigo_usuario')},
				reset: true
			});

			// Sponsors
			this.projectSponsorList.fetch({
				data: {codigo_entidad: this.model.get('codigo_entidad')},
				reset: true
			});

			// Members
			this.projectTeamList.fetch({
				data: {codigo_usuario: this.model.get('codigo_usuario')},
				reset: true
			});

			// Surveys
			this.projectSurveyListView = new app.ProjectSurveyListView({
				el: this.$wrapperSurvey,
				collection: this.surveysList,
				parameters: {
					dataFilter: {
						user: this.model.get('codigo_usuario')
					}
			   }
			});

			//  View programs is only seen by the owner or creator or permission see_programs_apply
			if(this.model.get('owner') || this.model.get('creator') || this.model.get('permissions').see_programs_apply) {
				// Programs
				this.projectProgramListView = new app.ProjectProgramListView({
			        collection: this.callList,
			        parameters: {
			        	'entityModel': this.model
			        }
				});

				// Render list program
				this.projectProgramListView.render();
				this.projectProgramListView.trigger('getdata', {
					'codigo_usuario': this.model.get('codigo_usuario')
				});
			}

            if( (this.model.get('owner') || this.model.get('creator') || this.model.get('permissions').see_bussines_model) && this.model.get('modelo_negocio_institucion')) {
                // Business Model
                this.businessModel.fetch({
                    data: {codigo_usuario: this.model.get('codigo_usuario')},
                    reset: true
                });

                // Business model
                this.projectBusinessModelView = new app.ProjectBusinessModelView({
                    model: this.businessModel,
                    parameters: {
                        'entityModel': this.model
                    }
                });
            }

			// to check project tabs
			if( this.parameters.tab ){
				this.stuffTab(this.parameters.tab);
			}

			// likes
			this.likeLinkView = new window.app.LikeView({
				el: this.$likeLink,
				collection: this.likeList,
				attributes: {
					'data-srcparams': this.model.get('srcparams')
				}
			});
			this.likeLinkView.$countLikes = this.$countLikes;

			// Instance gallery image collection
			this.galleryImages = new app.GalleryListView({
				el: this.$galleryEdit,
				collection: this.gallery,
				parameters: {
					viewItemImage: 'GalleryEditItemView',
					'codigo_involved': this.model.get('codigo_usuario'),
					thumbs: 9,
					dataFilter: {
						'codigo_usuario': this.model.get('codigo_usuario'),
						'codigo_tipo_adjunto': window._tp.getTypeAttached['gallery']
					}
				}
			});
			this.galleryImages.trigger('getdata');
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
		* switch tab section
		* @param String tab
		*/
		stuffTab: function ( tab ) {

			var _this = this,
				stuffTab = {
					'basico' : function() {
						_this.onGetBasic();
					},
					'integrantes' : function() {
						_this.onGetMembers();
					},
					'productos' : function() {
						_this.onGetProduct();
					},
					'discusiones' : function() {
						_this.onGetDiscussion();
					},
					'convocatorias' : function() {
						_this.onGetPrograms();
					},
					'documentos' : function() {
						_this.onGetDocument();
					},
					'encuestas' : function() {
						_this.onGetSurvey();
					},
					'modelodenegocio' : function() {
						_this.onGetBusinessModel();
					},
					'default': function () {
						_this.onGetBasic();
					}
				};

			if (stuffTab[tab]) {
				stuffTab[tab]();
				this.isDefault = false;

			} else {
				stuffTab['default']();
				this.isDefault = true;
			}
		},

		onGetBasic: function (e) {
			// set route
			if(!this.isDefault){
				app.AppRouter.navigate( Route.route('proyecto.proyecto.tab', {proyecto: this.model.get('url_nickname'), tab: 'basico'}), {trigger: false, replace: true} );
			}

			this.parameters.tab = 'basico';
		},

		onGetMembers: function (e) {

			// set route
			if(!this.isDefault){
				app.AppRouter.navigate( Route.route('proyecto.proyecto.tab', {proyecto: this.model.get('url_nickname'), tab: 'integrantes'}), {trigger: false, replace: true} );
			}

			this.parameters.tab = 'integrantes';
		},

		onGetProduct: function (e) {

			// Render product list view
			this.projectProductListView.render();
			this.projectProductListView.trigger('getdata');

			// set route
			if(!this.isDefault){
				app.AppRouter.navigate( Route.route('proyecto.proyecto.tab', {proyecto: this.model.get('url_nickname'), tab: 'productos'}), {trigger: false, replace: true} );
			}

			this.parameters.tab = 'productos';
		},

		onGetDiscussion: function (e) {

			// Render discussion entity list view
			this.userDiscussionListView.render();
			this.userDiscussionListView.trigger('getdata');

			// set route
			if(!this.isDefault){
				app.AppRouter.navigate( Route.route('proyecto.proyecto.tab', {proyecto: this.model.get('url_nickname'), tab: 'discusiones'}), {trigger: false, replace: true} );
			}

			this.parameters.tab = 'discusiones';
		},

		onGetPrograms: function (e) {

			// set route
			if(!this.isDefault){
				app.AppRouter.navigate( Route.route('proyecto.proyecto.tab', {proyecto: this.model.get('url_nickname'), tab: 'convocatorias'}), {trigger: false, replace: true} );
			}

			this.parameters.tab = 'convocatorias';
		},

		onGetDocument: function (e) {

			// set route
			if(!this.isDefault){
				app.AppRouter.navigate( Route.route('proyecto.proyecto.tab', {proyecto: this.model.get('url_nickname'), tab: 'documentos'}), {trigger: false, replace: true} );
			}

			this.parameters.tab = 'documentos';
		},

		onGetSurvey: function (e) {

			// Render list surveys
			this.projectSurveyListView.render();
			this.projectSurveyListView.trigger('getdata');

		   // set route
			if(!this.isDefault){
				app.AppRouter.navigate( Route.route('proyecto.proyecto.tab', {proyecto: this.model.get('url_nickname'), tab: 'encuestas'}), {trigger: false, replace: true} );
			}

			this.parameters.tab = 'encuestas';

		},

		onGetBusinessModel: function (e) {

		   // set route
			if(!this.isDefault){
				app.AppRouter.navigate( Route.route('proyecto.proyecto.tab', {proyecto: this.model.get('url_nickname'), tab: 'modelodenegocio'}), {trigger: false, replace: true} );
			}

			this.parameters.tab = 'modelodenegocio';

		},

		/**
		* Load spinner on the request
		*/
		loadSpinner: function (model, resp, opts) {

			if( this.model.changed['url_nickname'] ) {
				window.Misc.setSpinner( this.$el );
			}
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
			this.$modalBase.find('.content-modal').html( this.viewUserLikes.render().el );
			this.$modalBase.find('.content-modal').append( this.viewUserLikes.$wrapViewMore );

			this.$modalBase.foundation('reveal','open');
		},

		/**
		* on edit gallery
		*/
		onEditGallery: function (e) {
			e.preventDefault();

			var $productGallery = this.$('#project-gallery .item-gallery-image');

			if( $(e.target).is(':checked') ) {
				$productGallery.removeClass('light-preview-image');
				$productGallery.addClass('image-area-drop');
				$productGallery.find('> a').addClass('change-image-gallery');

			} else {
				$productGallery.removeClass('image-area-drop');
				$productGallery.addClass('light-preview-image');
				$productGallery.find('> a').removeClass('change-image-gallery');
			}
		},

		/**
		* render main image
		*/
		renderMainImage: function (model, value, opts) {

			this.$('#project-main-image').html( this.templateMainImg(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info basic
		*/
		renderInfoBasic: function (model, value, opts) {

			this.$('#project-name-container').html( this.templateTopDetail(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info Location
		*/
		renderInfoLocation: function (model, value, opts) {

			this.$('#project-location-container').html( this.templateLocation(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info Industry
		*/
		renderInfoIndustry: function (model, value, opts) {
			this.$('#project-industry-container').html( this.templateIndustry(this.model.toJSON()) );
			this.ready();
		},

        /**
		* render info Stage
		*/
		renderInfoStage: function (model, value, opts) {
			this.$('#project-stage-container').html( this.templateStage(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info tag
		*/
		renderInfoTag: function (model, value, opts) {

			this.$('#project-tag-container').removeClass('editing').html( this.templateTag(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info video
		*/
		renderInfovideo: function (model, value, opts) {

			this.$('#project-video-container').html( this.templateVideo(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info description
		*/
		renderInfoDescription: function (model, value, opts) {
			this.$('#project-description-container').removeClass('editing').find('.wrapper-description-project').html( this.templateDescription(this.model.toJSON()) );
			this.ready();
		},

		/**
		* render info summary
		*/
		renderInfoSummary: function (model, value, opts) {
		    var attributes = this.model.toJSON();
            var biografia = attributes.biografia_usuario || '' ;

            attributes.biografia_usuario = biografia.replace(/<\/?[^>]+(>|$)/g, "");
			this.$('#project-summary-container').removeClass('editing').html( this.templateSummary( this.model.toJSON() ) );
			this.ready();
		},

		/**
		* render info page web
		*/
		renderInfoPageWeb: function (model, value, opts) {
		    var attributes = this.model.toJSON();
            var url = attributes.pagina_web_usuario || '' ;

            attributes.pagina_web_usuario = url.replace(/<\/?[^>]+(>|$)/g, "");
			this.$('#project-pageweb-container').removeClass('editing').html( this.templatePageWeb( this.model.toJSON() ) );
			this.ready();
		},
		renderInfoNumeroWhatsapp: function (model, value, opts) {
		    var attributes = this.model.toJSON();
            var numero_whatsapp = attributes.numero_whatsapp || '' ;

            attributes.numero_whatsapp = numero_whatsapp;
			this.$('#project-numerowhatsapp-container').removeClass('editing').html( this.templateNumeroWhatsapp( this.model.toJSON() ) );
			this.ready();
		},
		/**
		 * Render Mail Contact
		 */
		renderMailContact: function (model, value, opts) {

			var attributes = this.model.toJSON();
			//console.log('Attributes', attributes);
			var mail_contact = attributes.correo_contacto || '';

			attributes.mail_contact = mail_contact.replace(/<\/?[^>]+(>|$)/g, "");
			this.$('#project-mail-contact').removeClass('editing').html( this.templateMailContact( this.model.toJSON() ) );
			this.ready();
		},

		/**
		* render info socials
		*/
		renderInfoSocials: function (model, value, opts) {

			this.$('#project-socials-container').html( this.templateSocials(this.model.toJSON()) );
			this.ready();
		},

		/**
		* update gallery
		*/
		updateGallery: function (galleryModel) {

			galleryModel.save({
				'direccion_adjunto': galleryModel.get('direccion_adjunto'),
				'codigo_usuario': this.model.get('codigo_usuario'),
				'codigo_privacidad_contenido': window._tp.typePrivacy['public'],
				'codigo_tipo_adjunto': window._tp.getTypeAttached['gallery'],
				'codigo_documento': window._tp.docAttached['image'],
				'_token': $('meta[name="csrf-token"]').attr('content')
			}, {patch:true, wait:true});
		},

		/**
		* destroy project
		*/
		onRemove: function (e) {
			e.preventDefault();

			this.confirmRemove = new app.ConfirmWindow({
				model:this.model,
				parameters: {
				    'titleConfirm' 	: _.template( ($('#project-title-confirm-remove-tpl').html() || '') ),
				    'template'		: _.template('<p>¿Estás seguro que quieres eliminarlo?</p>'),
				    'dataFilter': {
					   'codigo_usuario': this.model.get('codigo_usuario')
				    },
				    callBack: function (respState) {
					   if(respState) {
						   window.location = window.Misc.urlFull( Route.route('proyecto.tipo', {type:'micontenido'}) );
					   }
				    }
				}
			});
			this.confirmRemove.render();
		},
		onBack: function(e){
		    e.preventDefault();
		},

		onUserVote: function(e) {
			e.preventDefault();
            e.stopImmediatePropagation();

            if ( view instanceof Backbone.View ){
                view.stopListening();
                view.undelegateEvents();
            }

			var view = new app.VoteUserView({
				parameters: {
					entity: $(e.currentTarget).data('entity')
				}
			});

			view.render();
		}
   });

})(jQuery, this, this.document);
