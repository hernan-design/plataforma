/**
* Class StepProfileView extends of Backbone View
* @author TuProyecto || Desarrolladora : @xindykatalina
* @link http://TuProyecto.com
*/

//Global App Backbone
app || (app = {});

(function ($, window, document, undefined) {

    app.StepProfileView = Backbone.View.extend({

        el: '#general-user-info',
        template: _.template( ($('#step-profile-tpl').html() || '') ),
        templateEntity: _.template( ($('#step-profile-entity-tpl').html() || '') ),
        templateMainImg: _.template( ($('#main-image-profile-tpl').html() || '') ),
        templateProfessions: _.template( ($('#professions-profile-tpl').html() || '') ),
        templateIdentifications: _.template( ($('#identification-user-tpl').html() || '') ),
        events: {
        	'submit #form-step-profile': 'onStore',
            'click #change-image-step-profile': 'onChangeImage',
            'change .change-nickname-profile': 'onChangeNickname',
            'change #codigo_nivel_educacion': 'onChangeLevelEducation',
            'change #tipo_identificacion_usuario': 'onChangeTypeID',
            'change #year': 'onChangeDate',
            'change #month': 'onChangeDate',
            'change #day': 'onChangeDate'
        },
        parameters: {
           //
        },

        /**
        * Constructor Method
        */
        initialize : function(opts) {
            _.bindAll(this, 'beforeRender', 'render', 'afterRender', 'openModalImg', 'closeModalImg');

            // extends parameters
            if( opts.parameters !== undefined && _.isObject(opts.parameters) )
                _.extend(this.parameters, opts.parameters);

            //Init Attribute
            this.$modalImageCrop = $('#modal-chage-avatar');

            this.configAlert = {
                'wrapper': this.$el,
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
            this.listenTo( this.model, 'change:codigo_usuario' , this.render );
            this.listenTo( this.model, 'change:imagen_usuario', this.renderMainImage );

            this.listenTo( this.model, 'request', this.loadSpinner );
            this.listenTo( this.model, 'sync', this.responseServer );

            // Events Listener custome
            this.on( 'beforeRender', this.beforeRender );
            this.on( 'afterRender', this.afterRender );
        },

        /*
        * Render View Element
        */
        render: function() {

            var attributes = this.model.toJSON();
            this.$el.html( this.template(attributes) );

            // Initialize attributes
            this.$usernameMessage = this.$('.nickname-field-message');
            this.$usernamePath = this.$('.nickname-field-path');

            // Overwrite model id attribute
            if( this.model.changed.codigo_usuario !== undefined ) {
                // Overwrite id attribute of the model
                this.model.idAttribute = 'codigo_usuario';
                this.model.set({'codigo_usuario': this.model.get('codigo_usuario')},{'silent':true});

                // return to url initial of model
                this.model.returnToUrlRoot();

                // reference to view image
                this.renderMainImage();

                // reference to view professions
                if( $.inArray( this.model.get('codigo_nivel_educacion'), [window._tp.levelEducation.other, window._tp.levelEducation.baccalaureate] ) == -1 ) {
                    this.renderLevelProfessions();
                }

                this.onChangeDate(this.model.get('fecha_nacimiento_usuario'));

                if( !_.isUndefined(this.model.get('tipo_identificacion_usuario')) && !_.isNull(this.model.get('tipo_identificacion_usuario')) ){
                    this.validateInputIdentity( this.model.get('tipo_identificacion_usuario') );
                }else{
                    this.validateInputIdentity();
                }

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
                $(document).foundation('abide', 'reflow');
            }

            // reload plugins
            if( _.has($.fn, 'chosen') && typeof window.initComponent.chosenTrigger == 'function' )
                window.initComponent.chosenTrigger();

            if( _.has($.fn, 'select2') && typeof window.initComponent.select2Trigger == 'function' )
                window.initComponent.select2Trigger();

            if( typeof(window.initComponent.configInputMask) == 'function' && _.has($.fn, 'inputmask') )
                window.initComponent.configInputMask();

            if( typeof window.initComponent.initConfigForm == 'function' )
                window.initComponent.initConfigForm();

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
            var text = resp.success ? '' : resp.errors,
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
                'callback': (function (conf, re, _this) {
                    return function () {
                        if(re.success != undefined) {
                            if( re.success ){
                                window.Misc.redirect( window.Misc.urlFull( Route.route('step.entidad') ) );
                            }else{
                                window.Misc.showAlertBox( conf );
                            }
                        }
                    }
                })(this.configAlert, resp, this)
            });
        },

        /**
        * change nickname validate
        */
        onChangeNickname: function (e) {
            e.preventDefault();

            var _this = this,
                data = { nickname: $(e.currentTarget).val() };

            $.get( window.Misc.urlFull(Route.route('usuario.usernameavailable')), data, function (resp) {
                $(e.currentTarget).data( 'available', resp.success );

                // Message
                _this.$usernameMessage.removeClass('success-text alert-text hidesoft');
                _this.$usernameMessage.addClass(resp.success ? 'success-text' : 'alert-text');
                _this.$usernameMessage.html(resp.message);

                // Path
                _this.$usernamePath.removeClass('success-text alert-text hidesoft');
                _this.$usernamePath.addClass(resp.success ? 'success-text' : 'alert-text');
                _this.$usernamePath.html(resp.path);
            });
        },



        /**
        * change level education
        */
        onChangeLevelEducation: function (e) {
            e.preventDefault();

            this.$('#step-profile-professions').empty();
            if( $.inArray( parseInt($(e.currentTarget).val()), [window._tp.levelEducation.other, window._tp.levelEducation.baccalaureate] ) == -1 ) {
                this.renderLevelProfessions();
            }
        },

        /**
        * Change type ID
        */
        onChangeTypeID: function (e) {
            e.preventDefault();
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

            this.$('#identification-user').html( this.templateIdentifications( attributes ) );
            this.ready();
        },


        /**
        * render level education
        */
        renderLevelProfessions: function (model) {

            this.$('#step-profile-professions').html( this.templateProfessions( this.model.toJSON()) );
            this.ready();
        },

        /**
        * render main image
        */
        renderMainImage: function (model, value, opts) {

            this.$('#step-profile-main-image').html( this.templateMainImg( this.model.toJSON()) );
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
                formCrop: $('#form-avatar-crop'),
				imgCrop: $('#image-user-tocrop'),
				previewImg: $('#avatar-preview-tocrop'),
				uploaderImg: $('#uploader-image-avatar'),
				templateImgUploader: 'qq-img-uploader-template',
				configImg: {
					maxWidthImg : 240 * 10,
					maxHeightImg : 240 * 10,
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
                extraDropzones: [/*this.$('#project-main-image'),*/ $('#image-crop-avatar')],
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
                                _this.model.set('imagen_usuario', resp.file_path);

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

        onStore: function (e) {
             e.preventDefault();

            var data = window.Misc.formToJson( e.target );
            _.extend( data, {'checkaccount': true, 'view': 'rol','fecha_nacimiento_usuario': [data.year, data.month, data.day].join('-')} );
            this.model.save( data, {patch: true, wait: true} );
        },

        onChangeDate: function (e) {
            var fecha_nacimiento_usuario = [$('#year').val(), $('#month').val(), $('#day').val()].join('-');

            this.onValidateType(fecha_nacimiento_usuario);
        },

        onValidateType: function (param) {
            var typeIdentification = this.$('#tipo_identificacion_usuario');

            typeIdentification.removeData('param');
            typeIdentification.find('option:selected').remove().end().trigger('change.select2');

            typeIdentification.attr('data-param', param);
        }
   });

})(jQuery, this, this.document);
