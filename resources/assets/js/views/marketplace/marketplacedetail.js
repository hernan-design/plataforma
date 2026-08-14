/**
* Class MarketPlaceDetailView extends of Backbone View
* @author TuProyecto || Desarrolladores : @xindykatalina | @krobing
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.MarketPlaceDetailView = Backbone.View.extend({

        el: '#marketplace-content',
        template: _.template( ($('#product-detail-tpl').html() || '') ),
        templateMainImg: _.template( ($('#main-image-product-tpl').html() || '') ),
        templateTopDetail: _.template( ($('#info-basic-product-tpl').html() || '') ),
        templateSummary: _.template( ($('#info-summary-product-tpl').html() || '') ),
        templateClassification: _.template( ($('#info-classification-product-tpl').html() || '') ),
        templateDescription: _.template( ($('#info-description-product-tpl').html() || '') ),
        templateEntity: _.template( ($('#info-entity-product-tpl').html() || '') ),
        templateLocation: _.template( ($('#info-location-product-tpl').html() || '') ),
        events: {
            'submit #form-buy-product': 'onStore',
            'click .product-shared-list .show-user-likes': 'onShowUserLikes',
            'click #change-image-product': 'onChangeImage',
            'change .editable #edit-gallery-product': 'onEditGallery',
            'click #product-offer': 'onOffer'
        },
        parameters: {
            params: {}
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'openModalImg', 'closeModalImg');

            // extends parameters
			if( opts !== undefined && _.isObject(opts.parameters) ){
                this.parameters = $.extend({}, this.parameters, opts.parameters);
            }

            //Init Attribute
            this.purchaseModel = new app.PurchaseModel();
            this.discussionList = new app.DiscussionList();
            this.likeList = new app.LikeList();
            this.favoriteModel = new app.FavoriteModel();
            this.gallery = new app.AttachmentList();
            this.offerModel = new app.OfferModel();
            this.$modalLogin = $('#modal-login');
            this.$modalBase = $('#modal-base-tp');
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
            this.listenTo( this.model, 'change:id_producto', this.render );
            this.listenTo( this.model, 'change:state_product', this.toggleEditForm );
            this.listenTo( this.model, 'change:imagen_producto', this.renderMainImage );
            this.listenTo( this.model, 'change:nombre_producto change:codigo_proyecto', this.renderInfoBasic );
            this.listenTo( this.model, 'change:resumen_producto', this.renderInfoSummary );
            this.listenTo( this.model, 'change:seg_codigo_usuario', this.renderInfoEntity );
            this.listenTo( this.model, 'change:nombre_ciudad change:nombre_pais', this.renderInfoLocation );
            this.listenTo( this.model, 'change:codigo_categoria_prod_insti change:codigo_clase_producto change:precio_producto change:cantidad_producto change:domicilio_producto change:modalidad_texto', this.renderInfoClassification );
            this.listenTo( this.model, 'change:descripcion_producto', this.renderInfoDescription );
            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );
            this.listenTo( this.gallery, 'change', this.updateGallery );

            // Events Listener custome
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function() {
            var attributes = this.model.toJSON();
            console.log('Attributers', attributes);
            this.$el.html( this.template(attributes) );

            // Initialize attributes
            this.$countLikes = this.$('.data-count-likes');
            this.$likeLink = this.$('.data-post-share.TPlikelink');
            this.$galleryEdit = this.$('#product-gallery-marketplace');
            this.$wrapperDiscussion = this.$('#wrapper-posts-discussion');
            this.$buttonsActions = this.$('#buttons-marketplace-product-action');

            var validate = (this.model.get('owner') && this.model.get('state_product') == 'pending' && !this.model.get('restriction_edit')) ? true : false;

            this.$('#change-image-product').toggleClass('hidesoft', !validate);
            this.$('#opt-edit-gallery-product').toggleClass('hidesoft', !validate);
            this.$('#opt-edit-gallery-product').addClass('editable', validate);
            this.$('#section-content-product-detail').toggleClass('editable', validate);

            // overwrite model id attribute
            if( this.model.changed.id_producto !== undefined ) {

                // Overwrite id attribute of the model
                this.model.idAttribute = 'codigo_producto';
                this.model.set( {'codigo_producto': this.model.get('codigo_producto')}, {'silent':true} );

                // reference to views
                this.referenceViews();
                this.renderMainImage();
                this.renderInfoBasic();
                this.renderInfoSummary();
                this.renderInfoEntity();
                this.renderInfoClassification();
                this.renderInfoDescription();
                this.renderInfoLocation();
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

            // call image uploader crop
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

            // reload plugins
            if( typeof(window.initComponent.spinnerTrigger) == 'function' && _.has($.fn, 'sspinner') ){
                window.initComponent.spinnerTrigger();

                // validate product quantity
                this.$('#quantity-buy').sspinner('option', 'max', this.model.get('cantidad_producto') );

                if( parseInt(this.model.get('cantidad_producto')) <= 0 )
                    this.$('#quantity-buy').sspinner('option', 'disabled', true );
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

            // summary product for view more
            window.Misc.showMore({'container': this.$('.text-summary-product'), 'maxlen': 350});
        },

        /**
        * reference to views
        */
        referenceViews: function () {

            // instance of discussion view
            this.discussionListView = new app.DiscussionListView({
                el: this.$wrapperDiscussion,
                collection: this.discussionList,
                parameters: {
                    'formDiscussion': '#form-discussion-product',
                    dataFilter: {
                        'codigo_recurso_modulo': this.model.get('codigo_producto'),
                        'codigo_modulo': window._tp.getModule('marketplace'),
                        'belongs': this.model.get('owner')
                    }
                }
            });

            // instance of edit view
            this.marketplaceEdit = new app.MarketplaceEdit({
                model: this.model,
                parameters: {
                   //
                }
            });

            // Instance of Buttons Actions Product
            this.buttonsMarketPlace = new app.MarketPlaceProductActionsView({
                el: this.$buttonsActions,
                model: this.model,
                parameters: {
                    'type_action': ''
                }
            });

            // Instance gallery image collection
            this.galleryImages = new app.ProductGallery({
                el: this.$galleryEdit,
                collection: this.gallery,
                parameters: {
                    viewItemImage: 'ProductDetailGalleryImage',
                    'codigo_producto': this.model.get('codigo_producto'),
                    thumbs: 9,
                    dataFilter: {
                        'product': this.model.get('codigo_producto')
                    }
                }
            });
            this.galleryImages.trigger('getdata');

            // likes
            //to render like link for post
            this.likeLinkView = new window.app.LikeView({
                el: this.$likeLink,
                collection: this.likeList,
                attributes: {
                    'data-srcparams': this.model.get('srcparams')
                }
            });

            this.likeLinkView.$countLikes = this.$countLikes;

            // instance favorite
            this.favoriteView = new app.FavoriteView({
                el: this.$('.post-favorite-icon.TPfavoritelink'),
                model: this.favoriteModel,
                parameters: {
                    codFavorite: this.model.get('codigo_favorito'),
                    favoriteState: this.model.get('favorito_auth'),
                    srcparams: this.model.get('srcparams')
                }
            });

        },

        /**
        * Load spinner on the request
        */
        loadSpinner: function () {

            if( this.model.changed['url_producto'] !== undefined ) {
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
        * Event Buy Product
        */
        onBuyProduct: function (e) {
            e.preventDefault();

            var data = window.Misc.formToJson( e.target ),
                queries = { product: this.model.get('url_producto') } ;

            if(!_.isEmpty(this.parameters.params)){
                _.extend(queries, this.parameters.params);
            }

            if(this.model.get('manejo_unidades')) {
                queries.quantity = data.unidades;
            }

            window.Misc.redirect( window.Misc.urlFull(Route.route( 'marketplace.compras.create', queries), {trigger: true} ) );
        },

        /**
        * Event Create Purchase Order
        */
        onStore: function (e) {
            e.preventDefault();
            var _this = this
            var data = window.Misc.formToJson( e.target );
            data.codigo_producto = this.model.get('codigo_producto');
            nombre_producto = this.model.get('nombre_producto');

            var purchase_url = window.Misc.urlFull(Route.route('marketplace.compras.store'));
            _this.purchaseModel.save(data, {
                wait: true,
                type: 'post',
                url: purchase_url,
                success: function(model, response) {
                    if (response.success && response.redirect) {
                        // Reemplazamos el {shipping} con el codigo_compra devuelto en la respuesta
                        var fullUrl = window.Misc.urlFull(
                            Route.route(response.redirect, { shipping: response.codigo_compra })
                        );
                        window.location.href = fullUrl;
                    }
                },
                error: function(model, response) {
                    console.error('Error al guardar la orden de compra:', response);
                }
            });



            // this.confirmOffer = new app.ConfirmWindow({
            //     model: this.model,
            //     parameters: {
            //         template: _.template( ($('#purchase-store-confirm-tpl').html() || '') ),
            //         titleConfirm : 'Compra de "' + nombre_producto + '"' ,
            //         onConfirm: function () {
            //             var purchase_url = window.Misc.urlFull(Route.route('marketplace.compras.store'));
            //             _this.purchaseModel.save( data, { wait:'true', type:'post', url:purchase_url} );

            //         }
            //     }
            // });
            // this.confirmOffer.render();
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

            var $productGallery = this.$('#product-gallery-marketplace .product-gallery-image');

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
            this.$('#product-main-image').html( this.templateMainImg(this.model.toJSON()) );
            this.ready();
        },

        /**
        * render info toggleEditForm
        */
        toggleEditForm: function (model, value, opts) {

            var validate = (this.model.get('owner') && this.model.get('state_product') == 'pending') ? true : false;

            if(!this.model.get('restriction_edit')){
                this.$('#top-product-detail').toggleClass('editable', validate);
                this.$('#section-content-product-detail').toggleClass('editable', validate);
                this.$('#change-image-product').toggleClass('hidesoft', !validate);
                this.$('#opt-edit-gallery-product').toggleClass('hidesoft', !validate);
            }else{
                this.$('#change-image-product').toggleClass('hidesoft', !validate);
                this.$('#opt-edit-gallery-product').toggleClass('hidesoft', !validate);
                this.$('#section-content-product-detail').toggleClass('editable', validate);
            }

        },

        /**
        * render info basic
        */
        renderInfoBasic: function (model, value, opts) {
            this.$('#product-infobasic-container').html( this.templateTopDetail(this.model.toJSON()) );
            this.ready();
        },

        /**
        * render info summary
        */
        renderInfoSummary: function (model, value, opts) {

            this.$('#product-summary-container').removeClass('editing').html( this.templateSummary(this.model.toJSON()) );
            this.ready();
        },

        /**
        * render info entity
        */
        renderInfoEntity: function (model, value, opts) {
            this.$('#product-infoentity-container').html( this.templateEntity(this.model.toJSON()) );
            this.ready();
        },

        /**
        * render info classification
        */
        renderInfoClassification: function (model, value, opts) {

            this.$('#product-infoclasification-container').html( this.templateClassification(this.model.toJSON()) );
            this.ready();
        },

        /**
        * render info description
        */
        renderInfoDescription: function (model, value, opts) {
            this.$('#product-infodescription-container').removeClass('editing').html( this.templateDescription(this.model.toJSON()) );
            this.ready();
        },

        /**
        * render info location
        */
        renderInfoLocation: function (model, value, opts) {
            this.$('#product-location-container').html( this.templateLocation(this.model.toJSON()) );
            this.ready();
        },

        /**
        * update gallery
        */
        updateGallery: function () {

            this.model.save( {'images_gallery': this.gallery.toJSON()}, {patch:true, wait:true} );
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
                                _this.model.save({'imagen_producto': resp.file_path}, {
                                    patch: true,
                                    wait: true,
                                    success: function (model, resp, opts) {
                                        // body...
                                    }
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
                this.$el.imageUploaderCrop('changeImage', this.model.get('imagen_producto'));
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

        /**
        * Offer product
        */
        onOffer: function (e) {

            e.preventDefault();

            // Confirm Offer
            if( window.Misc.checkSession(false) ) {

                var _this = this,
                    data = window.Misc.formToJson(this.$('#form-buy-product')),
                    offerData = _.pick(data, 'unidades', 'valor_total_compra', '_token');
                var precioProducto = this.model.get('producto_sin_precio') ? 0 : this.model.get('precio_producto');
                if(offerData.valor_total_compra > precioProducto){
                    var config = {
                        'text': 'El valor de la oferta debe ser menor al valor del producto.',
                        'type': 'alert'
                    };
                    _.extend( _this.configAlert, config );
                    window.Misc.showAlertBox( _this.configAlert );
                    return;
                }

                offerData['codigo_producto'] = this.model.get('codigo_producto');

                // validate fieldset inputs
                if( !this.validateFields() )
                    return;

                this.confirmOffer = new app.ConfirmWindow({
                    model: this.model,
                    parameters: {
                        template: _.template( ($('#product-confirm-offer-tpl').html() || '') ),
                        titleConfirm : '¿Estás seguro que quieres ofertarlo?',
                        onConfirm: function () {
                            _this.offerModel.save(offerData, {
                                wait: true,
                                success: function(model, resp) {
                                    // response success or error
                                    var type = resp.success ? 'success' : 'alert',
                                        text = resp.success ?
                                            (resp.message !== undefined ? resp.message : '...')
                                            : resp.errors;

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
                                    _.extend( _this.configAlert, config );

                                    if( resp.success !== undefined ) {
                                        if( resp.success ){
                                            window.Misc.redirect( window.Misc.urlFull(Route.route( 'marketplace.compras.success', {purchase: resp.codigo_compra} )) );
                                            return;
                                        }else{
                                            window.Misc.showAlertBox( _this.configAlert );
                                        }
                                    }
                                }
                            });
                        }
                    }
                });
                this.confirmOffer.render();

            }else {
                this.$modalLogin.foundation('reveal','open');
            }
        },

        /**
        * @param fieldSet String|Element
        * @param e Event|Object with property type
        */
        validateFields: function (fieldSet) {
            fieldSet || (fieldSet = '');

            return Foundation.libs.abide.validate(this.$('#form-buy-product').find('input, textarea, select').get(), {type:'submit'}, false);
        }
   });

})(jQuery, this, this.document);
